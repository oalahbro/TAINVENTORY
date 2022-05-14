<?php
class Mongodb{
    function table($col) {
        $client = new MongoDB\Client("mongodb://ekacuk:404notfound@localhost:27017"); // koneksi ke mongo db
        // $client = new MongoDB\Client('mongodb://evantoday:babybear55@cluster0-shard-00-00.s2hx8.mongodb.net:27017,cluster0-shard-00-01.s2hx8.mongodb.net:27017,cluster0-shard-00-02.s2hx8.mongodb.net:27017/test?replicaSet=atlas-tsmeyc-shard-0&ssl=true&authSource=admin');
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