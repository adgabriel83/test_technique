<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Lien;
use App\Entity\Materiel;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // On crée 100 materiels avec un prix entre 10000 et 1000000 (en centimes)
        $tabMateriel = [];
        for($i=0;$i<100;$i++) {
            $materiel = new Materiel();
            $materiel->setName('Matériel '.$i);
            $materiel->setPrice(rand(100,10000)*100); // Prix en centimes en bdd
            $manager->persist($materiel);
            $tabMateriel[] = $materiel;
        }

        // On crée 20 clients
        $tabClient = [];
        for($i=0;$i<20;$i++) {
            $client = new Client();
            $client->setFirstName('Prénom '.$i);
            $client->setLastName('Nom '.$i);
            $client->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($client);
            $tabClient[] = $client;
        }

        // On ajoute un certains nombre de matériels à chaque client
        foreach($tabClient as $client) {
            $nbLien = rand(1,5); // Nombre de liens à créer entre 1 et 5
            while($nbLien-- > 0) { // Juste pour changer un peu du for
                $lien = new Lien();
                $lien->setClient($client);
                $lien->setMateriel($tabMateriel[rand(0,count($tabMateriel)-1)]); // On récupère un matériel aléatoire
                $lien->setQuantity(rand(1,50)); // Quantité aléatoire entre 1 et 50
                $manager->persist($lien);
            }
        }


        $manager->flush();
    }
}
