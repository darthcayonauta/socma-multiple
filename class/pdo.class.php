<?php
/**
 * clase de conexion usando PDO
 */
class PdoConnect
{
    private $pdo;
    private $host;
    private $user;
    private $password;
    private $db;

    function __construct()
    {
        $oConf    = new config();
        $cfg      = $oConf->getConfig();

        $this->host     = $cfg['base']['dbhost'];
        $this->user     = $cfg['base']['dbuser'];
        $this->password = $cfg['base']['dbpass'];
        $this->db       = $cfg['base']['dbdata'];
    }

    private function connect()
    {
        try{
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db}",$this->user,$this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(Exception $e){
            return "Error, no se ha podido conectar a la db {$this->db} ";
        }
    }

    private function disconnect()
    {
        $this->pdo = null;
    }


    public function getMethod( $query = null )
    {
        try {
            $this::connect();
            $sentence = $this->pdo->prepare($query);
            $sentence->execute();
            $this::disconnect();
            return $sentence;

        }
        catch (Exception $e)
        {
            die( "Error:".$e );
        }

    }
//aun no me voy a casar con los otros métodos de PDO

}
?>
