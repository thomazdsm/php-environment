<?php

namespace TSM;

use \Exception;

/**
 * Create and Load the Environment Variables
 */
class Environment
{
    /**
     * Method responsible for checking if .env and .env.example files exists. If not, create it.
     * @param $dir
     * @return true
     */
    private static function fileExists($dir) {

        try {
            $envFilePath = $dir . '/.env';
            $exampleFilePath = $dir . '/.env.example';

            // Verifica se o arquivo .env existe
            if (!file_exists($envFilePath)) {
                // Verifica se o arquivo .env.example existe
                if (!file_exists($exampleFilePath)) {
                    // Cria um novo arquivo .env com base em um modelo
                    $exampleContent = "APP_NAME=AppName\n"
                        . "APP_ENV=local\n"
                        . "APP_DEBUG=true\n"
                        . "APP_URL=http://localhost\n\n"
                        . "DB_CONNECTION=mysql\n"
                        . "DB_HOST=127.0.0.1\n"
                        . "DB_PORT=3306\n"
                        . "DB_DATABASE=\n"
                        . "DB_USERNAME=\n"
                        . "DB_PASSWORD=\n"
                        . "DB_PREFIX=";

                    file_put_contents($exampleFilePath, $exampleContent);
                }
                // Cria o arquivo .env a partir do arquivo .env.example
                copy($exampleFilePath, $envFilePath);
            }
            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Method responsible for loading the project's environment variables
     * @param $dir
     * @return void
     * @throws Exception
     */
    public static function load($dir)
    {
        if(self::fileExists($dir)) {
            $envFilePath = $dir . '/.env';

            // Carrega as variáveis de ambiente do arquivo .env
            $lines = file($envFilePath);
            foreach ($lines as $line) {
                $trimmedLine = trim($line);
                if (!empty($trimmedLine)) {
                    putenv($trimmedLine);
                }
            }
        }
    }

}