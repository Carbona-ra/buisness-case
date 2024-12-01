<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Advertise;
use App\Entity\AdvertiseImage;
use App\Entity\DisponibilitieDate;
use App\Entity\Message;
use App\Entity\Reaction;
use App\Entity\Reservation;
use App\Entity\Service;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{

    const USER_NAMES = ["Bernard", "Faker", "Dylan", "Taraz", "Jhon", "Conrad", "Philipe", "Maxence", "Pierre"];
    const SERVICES = ["Machine à café", "Piscine", "Salle de sport", "Wi-Fi gratuit", "Parking", "Petit déjeuner inclus", "Salle de réunion", "Climatisation", "Service de nettoyage", "Télévision", "Accès au jardin", "Salle de jeux"];
    const IMAGES = [
        "https://images.unsplash.com/photo-1555066888-e3a53c0ab20e", 
        "https://images.unsplash.com/photo-1581291518820-96318c4882f7", 
        "https://images.unsplash.com/photo-1613469208042-429b26c1e92c",
        "https://images.unsplash.com/photo-1531746866671-5078d5b4c34c", 
        "https://images.unsplash.com/photo-1542653937-bc3d622baaa2", 
        "https://images.unsplash.com/photo-1574180045820-6912f2502de4", 
        "https://images.unsplash.com/photo-1516591678893-85e38347753e", 
        "https://images.unsplash.com/photo-1593642632825-e4d4c8e5f6e6", 
        "https://images.unsplash.com/photo-1574170453686-7e0f8e97b40f",
        "https://images.unsplash.com/photo-1593642532400-505c8c77e1e1", 
    ];

   public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Créer un administrateur
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setFirstname('benjamin');
        $admin->setLastname('Schacher');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword('1234admin');
        $manager->persist($admin);

        $tom = new User();
        $tom->setEmail('tom@example.com');
        $tom->setFirstname('tom');
        $tom->setLastname('Schacher');
        $tom->setRoles(['ROLE_USER']);
        $tom->setPassword('1234admin');
        $manager->persist($tom);

        $ben = new User();
        $ben->setEmail('ben@example.com');
        $ben->setFirstname('ben');
        $ben->setLastname('Schacher');
        $ben->setRoles(['ROLE_LANDLORD','ROLE_USER']);
        $ben->setPassword('1234admin');
        $manager->persist($ben);

        $users = [];
        $adresses = [];
        $advertises = [];

        // Créer des utilisateurs avec des adresses
        for ($i = 0; $i < 9; $i++) {
            // Créer un utilisateur
            $user = new User();
            $user->setEmail($faker->email);
            $user->setFirstname(self::USER_NAMES[$i]);
            $user->setLastname($faker->lastName);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($faker->password());

            // Créer une adresse pour l'utilisateur
            $adresse = new Adresse();
            $adresse->setCity($faker->city);
            $adresse->setStreetName($faker->streetName);
            $adresse->setAdresseNumber($faker->numberBetween(1, 200));
            $adresse->setCountry($faker->country);
            $adresse->setPostalCode(66999);

            // Associer l'adresse à l'utilisateur
            $user->setAdresse($adresse);

            // Persister l'utilisateur et l'adresse
            $manager->persist($user);
            $manager->persist($adresse);

            // Stocker les utilisateurs et les adresses pour plus tard
            $users[] = $user;
            $adresses[] = $adresse;
        }

        // Créer des annonces
        for ($i = 0; $i < 20; $i++) {
            $advertise = new Advertise();
            $advertise->setTitle($faker->sentence(3));
            $advertise->setDescription($faker->paragraph(5));
            $advertise->setPrice($faker->numberBetween(100, 1000));
            $advertise->setPresentationPicture($faker->imageUrl());
            $advertise->setGallery($faker->imageUrl());
            $advertise->setTotalPlaceNumber($faker->numberBetween(2, 10));
            $advertise->setActualNumberPlace($faker->numberBetween(0, 10));


            // Relier l'annonce à une adresse et un utilisateur aléatoire
            $randomUserIndex = array_rand($users);
            $advertise->setAdresse($adresses[$randomUserIndex]);
            $advertise->setUser($users[$randomUserIndex]);

            // Persister l'annonce
            $manager->persist($advertise);

            // Ajouter l'annonce à la liste
            $advertises[] = $advertise;
        }

        // Créer des images d'annonces et les relier aux annonces
        foreach ($advertises as $advertise) {
            // Choisir une image aléatoire
            $imageUrl = self::IMAGES[array_rand(self::IMAGES)];
            $advertiseImage = new AdvertiseImage();
            $advertiseImage->setAvertise($advertise);
            $advertiseImage->setImageSlug($imageUrl);
            $randomUserIndex = array_rand($users);

            // Persister l'image
            $manager->persist($advertiseImage);
        }

        // Créer des services et les relier aux annonces
        foreach ($advertises as $advertise) {
            // Choisir un service aléatoire
            $serviceName = self::SERVICES[array_rand(self::SERVICES)];
            $service = new Service();
            $service->setName($serviceName);
            $service->setAdvertise($advertise);

            // Persister le service
            $manager->persist($service);
        }

        // Créer des disponibilités et les relier aux annonces
        foreach ($advertises as $advertise) {
            $disponibilitieDate = new DisponibilitieDate();
            $disponibilitieDate->setStartedAt($faker->dateTimeBetween('now', '+1 month'));
            $disponibilitieDate->setEndedAt($faker->dateTimeBetween('+1 month', '+2 months'));
            $disponibilitieDate->setAdvertise($advertise);

            // Persister la disponibilité
            $manager->persist($disponibilitieDate);
        }

        // Créer des réservations et les relier aux utilisateurs et aux annonces
        for ($i = 0; $i < 10; $i++) {
            $reservation = new Reservation();
            $reservation->setStartedAt($faker->dateTimeBetween('now', '+1 month'));
            $reservation->setEndAt($faker->dateTimeBetween('+1 month', '+2 months'));

            // Choisir un utilisateur et une annonce aléatoire
            $randomUserIndex = array_rand($users);
            $randomAdvertiseIndex = array_rand($advertises);

            $reservation->setUser($users[$randomUserIndex]);
            $reservation->setAdvertise($advertises[$randomAdvertiseIndex]);

            // Persister la réservation
            $manager->persist($reservation);
        }

        // Créer des réactions pour les annonces
        foreach ($advertises as $advertise) {
            // Choisir un utilisateur aléatoire
            $randomUserIndex = array_rand($users);
            $reaction = new Reaction();
            $reaction->setUser($users[$randomUserIndex]);

            // Générer une note aléatoire entre 1 et 5
            $reaction->setNote($faker->numberBetween(1, 5));

            // Générer un statut aléatoire pour isFavorite
            $reaction->setFavorite($faker->boolean());

            // Associer la réaction à l'annonce
            $reaction->setAdvertise($advertise);

            // Persister la réaction
            $manager->persist($reaction);
        }

        // Créer des messages entre utilisateurs
        for ($i = 0; $i < 5; $i++) {
            // Choisir deux utilisateurs différents
            $senderIndex = array_rand($users);
            $receiverIndex = array_rand($users);

            // S'assurer que l'expéditeur et le destinataire sont différents
            while ($senderIndex === $receiverIndex) {
                $receiverIndex = array_rand($users);
            }

            // Déterminer le nombre de messages pour cette conversation (entre 1 et 5)
            $numberOfMessages = rand(1, 5);

            for ($j = 0; $j < $numberOfMessages; $j++) {
                $message = new Message();
                $message->setContent($faker->sentence(10)); // Contenu du message
                $message->setCreatedAt(new \DateTime()); // Date actuelle

                // Associer l'expéditeur et le destinataire
                $message->setSender($users[$senderIndex]);
                $message->setReciver($users[$receiverIndex]);

                // Persister le message
                $manager->persist($message);
            }
        }

        $manager->flush();
    }
}
