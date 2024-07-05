<?php
    session_start();

    /**
     * A utility function to dump a variable and stop the script execution.
     *
     * @param mixed $var The variable to dump.
     */
    function dd($var) {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        die(); // Stop script execution after dumping.
    }

    /**
     * Establishes a connection to the MySQL database using PDO.
     *
     * @return PDO Returns a PDO connection object.
     */
    function connect() {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");

            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $e) {
            // Handle connection errors gracefully
            dd('Connection failed: ' . $e->getMessage());
        }
    }
?>
