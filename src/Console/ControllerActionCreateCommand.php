<?php namespace FrenchFrogs\Maker\Console;

use Carbon\Carbon;
use gossi\codegen\generator\CodeGenerator;
use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;
use gossi\docblock\Docblock;
use gossi\docblock\tags\TagFactory;
use Illuminate\Console\Command;

class ControllerActionCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffmake:action
                             {controller : Nom du controller en minuscule}
                             {method : Méthode pour l\'action (post, get, etc...)}
                             {name : Nom de l\action}
                             {--acl= : Permission pour l\'accès}
                             {--params= : Paramètre pour l\'action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Création d'une action pour le controller";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $controller = $this->argument('controller');

        // Gestion des paramètres
        $params = [];
        $p = $this->option('params');
        if($p) {

            // recupération des paramètres
            foreach( explode('#', $p) as $param) {
                $parts = explode(';', $param);

                // paramètres
                $variable = array_shift($parts);

                $match = [];
                if (!preg_match('#((?<type>\w+)\|)?(?<name>\w+)(=(?<value>.+))?#', $variable, $match)) {
                    exc('Impossible de determiner les paramètres : ' . $variable);
                }

                // recuperation du nom du paramètre
                $name = $match['name'];

                // initialisation du container
                $params[$name] = [];

                // Class
                if (isset($match['type'])) {
                    $params[$name]['type'] = $match['type'];
                }

                // Valeur par default
                if (isset($match['value'])) {
                    $params[$name]['value'] = $match['value'];
                }

                // validateur
                if($validator = array_shift($parts)) {
                    if (!empty($validator)) {
                        $params[$name]['validator'] = $validator;
                    }
                }


                // filter
                if($filter = array_shift($parts)) {
                    if (!empty($filter)) {
                        $params[$name]['filter'] = $filter;
                    }
                }
            }
        }

        // création de la méthode
        $method = camel_case($this->argument('method') .  '_' . $this->argument('name'));
        $method = PhpMethod::create($method);


        // Inscription des paramètre
        foreach ($params as $name => $info) {
            $param = PhpParameter::create($name);

            if (isset($info['type'])) {
                $param->setType($info['type']);
            }

            if (isset($info['value'])) {
                // Cas de la valeur non obligatoire
                if ($info['value'] == 'null') {
                    $info['value'] = null;
                }
                $param->setValue($info['value']);
            }
            $method->addParameter($param);
        }

        // Gestion du body
        $body = '';

        // Ruler
        $validator = $filter = [];
        foreach ($params as $name => $info) {
            $validator[] = sprintf("['%s' => '%s']", $name, $info['validator']);
            if (!empty($info['filter'])) {
                $filter[] = sprintf("['%s' => f('%s', \$%s)]", $name, $info['filter'], $name);
            } else {
                $filter[]=  sprintf("['%s' => \$%s]", $name, $name);
            }
        }

        $ruler = [];
        $acl = $this->option('acl') ?: 'null';
        $ruler[] = $acl;

        if (!empty($validator)) {
            $validator = implode(',',$validator);
            $filter = implode(',',$filter);
            $ruler[] = $validator;
            $ruler[] = $filter;
        }

        if ($acl || $validator) {
            $body .= sprintf("\\ruler()->check(%s);", PHP_EOL . implode(',' . PHP_EOL, $ruler) . PHP_EOL);
        }

        // block de commentaire
        $dockblock = new Docblock();
        $dockblock->appendTag(TagFactory::create('name', 'Artisan'));
        $dockblock->appendTag(TagFactory::create('see', 'php artisan ffmake:action'));
        $dockblock->appendTag(TagFactory::create('generated', Carbon::now()));
        $method->setDocblock($dockblock);


        // Gestion du retour
        $body .= str_repeat(PHP_EOL, 3) . "return basic('_TITRE_', '_CONTENT_');";
        $method->setBody($body);

        // Récupération du controller à mettre à jour
        $controller = ucfirst(camel_case($controller . '_controller'));
        $controller = app_path('Http/Controllers/') . $controller . '.php';
        $class = PhpClass::fromFile($controller)->setMethod($method);

        // Génration du code
        $generator = new CodeGenerator();
        $class = '<?php ' . $generator->generate($class);

        // inscription du code dans la classe
        file_put_contents($controller, $class);

        $this->info('Action generated dans le fichier : ' . $controller);
    }
}
