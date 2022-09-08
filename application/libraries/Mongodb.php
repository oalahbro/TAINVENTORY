<?php
class Mongodb{
    function table($col) {
        $client = new MongoDB\Client("mongodb://ekacuk:404notfound@localhost:27017"); // koneksi ke mongo db
        
        $database = 'mongophp'; // nama database
        $collection = $client->$database->$col; //nama collection
        return $collection;
	}
    function id() {
        $objid = new MongoDB\BSON\ObjectId();
        $id = (array)$objid;
        $subs = substr($id['oid'], 14, 24);
        return $subs;
    }
}