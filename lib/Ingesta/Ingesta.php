<?php
namespace Ingesta;

use Ingesta\Inputs\InputFactory;

class Ingesta
{
    const VERSION = '0.0.1';
    const RECIPE_DIR = 'share/recipes';
    const STATE_DIR  = 'tmp/recipes';

    protected static $shortCmdOptions = '';
    protected static $longCmdOptions  = array(
        'help',
        'recipe::'
    );


    public static function run()
    {
        echo 'Ingesta v', self::VERSION, "\n";
        $self    = new Ingesta();
        $cmdArgs = $self->getCmdArgs();
        $self->execute($cmdArgs);
    }


    public function execute($args)
    {
        //print_r($args);
        if (isset($args['recipe'])) {
            $recipeName = $args['recipe'];
            $recipe = $this->loadRecipe($recipeName);

            if ($recipe) {
                $state = $this->loadState($recipeName);

                if (isset($state->lastRun)) {
                    echo "Running recipe '$recipeName'. Last run: {$state->lastRun}\n";
                } else {
                    echo "Running recipe '$recipeName'. First time\n";
                }

                $this->executeRecipe($recipe, $state);

                $state->lastRun = date('c');
                $this->saveState($recipeName, $state);
            } else {
                echo "No recipe named '{$recipeName}' found. Exiting.\n";
            }
        }
    }


    protected function executeRecipe($recipe, $state)
    {
        $input     = $this->getInput($recipe->input);

    }


    protected function getInput($inputConfig)
    {
        $inputFactory = InputFactory::getInstance();
        $input        = $inputFactory->getInput($inputConfig);
        echo "Input: "; print_r($input);

        return $input;
    }


    protected function loadRecipe($recipeName)
    {
        $recipe   = null;
        $filePath = self::RECIPE_DIR . '/' . $recipeName . '.json';

        if (is_file($filePath)) {
            $recipe = json_decode(file_get_contents($filePath));
        }

        return $recipe;
    }


    protected function loadState($recipeName)
    {
        $state    = null;
        $filePath = self::STATE_DIR . '/' . $recipeName . '.state.json';

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        if (is_file($filePath)) {
            $state = json_decode(file_get_contents($filePath));
        } else {
            $state = $this->initState($recipeName);
        }

        return $state;
    }


    protected function initState()
    {
        $state = (object) array ();

        return $state;
    }


    protected function saveState($recipeName, $state)
    {
        $filePath = self::STATE_DIR . '/' . $recipeName . '.state.json';
        $jsonDoc  = json_encode($state);
        $response = file_put_contents($filePath, $jsonDoc);
        return $response;
    }


    protected function getCmdArgs()
    {
        $args = getopt(
            self::$shortCmdOptions,
            self::$longCmdOptions
        );

        return $args;
    }
}
