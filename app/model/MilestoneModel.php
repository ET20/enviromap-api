<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class MilestoneModel {
    private $db;
    private $unitm = 'milestone';
    private $response;
    
    public function __CONSTRUCT() {
        $this->db = Database::StartUp();
        $this->response = new Response();
    }
    
// si funca
    public function GetAll()
    {
        try {
           
                $stm = $this->db->prepare(
                    "SELECT * FROM milestone"
                    
                    );

                $stm->execute();  

                $this->response->setResponse(true);

            $this->response->result = $stm->fetchAll();
            
            return $this->response;  
            
            

            
            
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
            }
    }

// si funca
    public function Get($id)
    {
        try {
            $stm = $this->db->prepare("
                SELECT * FROM milestone
                WHERE idmilestone = ?");
            $stm->execute(array($id));

            $this->response->setResponse(true);

            $this->response->result = $stm->fetch();

            return $this->response;

        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }


    public function Insert($data)
    {
        try {
            $sql = "INSERT INTO milestone
                    (idtype,
                    name,
                    description,
                    lat,
                    lon,
                    created,
                    lastupdate)
                    VALUES (?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            (select now ()) )
                            ;";

            $this->db->prepare($sql)
                ->execute(
                    array(
                        $data['idtype'],
                        $data['name'],
                        $data['description'],
                        $data['lat'],
                        $data['lon'],
                        $data['created'],
                        $data['lastupdate']
                        
                    )
                );

            $this->response->setResponse(true);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }


    public function Update($data)
    {
        try {
            if (isset($data['idmilestone'])) {
                $sql = "UPDATE milestone SET
                            idtype      = ?,
                            name        = ?,
                            description = ?,
                            lat         = ?,
                            lon         = ?,                         
                            created     = ?,
                            lastupdate  = ?
                        WHERE idmilestone = ?";

                $idmilestone = intval($data['idmilestone']);
                $this->db->prepare($sql)
                    ->execute(
                        array(
                            $data['idtype'],
                            $data['name'],
                            $data['description'],
                            $data['lat'],
                            $data['lon'],
                            $data['created'],
                            $data['lastupdate'],
                            $idmilestone,
                        )
                    );
            }

            $this->response->setResponse(true);

            return $this->response;

        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

// si funca
    public function Delete($id)
    {
        try
        {
            $stm = $this->db
                ->prepare("DELETE FROM milestone WHERE idmilestone = ?");

            $stm->execute(array($id));

            $this->response->setResponse(true);
            return $this->response;

        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
}
