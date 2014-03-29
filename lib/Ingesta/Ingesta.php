<?php
namespace Ingesta;

use Ingesta\Services\InputFactory;

class Ingesta
{
    const VERSION = '0.0.1';
    const RECIPE_DIR = 'share/recipes';

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
                $this->executeRecipe($recipe);
            }
        }
    }


    protected function executeRecipe($recipe)
    {
        echo "Recipe to run: ";
        print_r($recipe);
        $input = $this->getInput($recipe->input);

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


    protected function getCmdArgs()
    {
        $args = getopt(
            self::$shortCmdOptions,
            self::$longCmdOptions
        );

        return $args;
    }
}
