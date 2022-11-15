<?php

namespace App\DataFixtures;

use App\Entity\Athlete;
use App\Entity\Delegation;
use App\Entity\Epreuve;
use App\Entity\Event;
use App\Entity\Record;
use App\Entity\Sport;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($userNumber=0; $userNumber < 2; $userNumber++) { 
            $basicUser = new User;
            $manager->persist($basicUser);
            $basicUser->setEmail($faker->email());
            $hashedPassword = $this->passwordHasher->hashPassword($basicUser, "admin");
            $basicUser->setPassword($hashedPassword);

            $userList[] = $basicUser;
        }
        
        $nbrDelegation= 5;
        $nbrAthlete = 10;
        $nbrEvent = 5;

        $sportFaker = [
            "Football",
            "Athlétisme",
            "Basketball",
            "Badminton",
            "Escrime",
            "Gymnastique",
            "Aviron",
            "Cyclisme",
            "Trampoline",
            "Rugby",
            "Voile",
            "Volleyball",
            "Tir",
            "Tir à l'arc",
            "Waterpolo",
            "Natation",
            "Triathlon",
            "Tennis",
            "Tennis de table",
            "Sports équestres",
            "Taekwondo",
            "Judo",
            "Lutte"
        ];

        $cityFaker = [
            "Marseille",
            "Paris",
            "Lyon",
            "Lille",
            "Saint-etienne",
            "Bordeaux",
            "Nantes"
        ];

        $eventNameFaker = [
            "Meeting sportif",
            "Exposition photo autour des jeux Olympiques",
            "Formes Olympiques : festival sport/art",
            "Journées d'initiation pour la journée paralympique",
            "Ateliers maison du projet du village des athlètes"
        ];

        $recordFaker = [
            "Médaille d'or",
            "Médaille d'argent",
            "Médaille de bronze",
            "Champion national",
            "Champion du monde",
            "Champion continentale",
            "Champion régional",
            "Champion départementale"
        ];

        for ($sportNumber = 0; $sportNumber < count($sportFaker); $sportNumber++) {
            $sport = new Sport;
            $manager->persist($sport);
            $sport->setCategory($sportFaker[$sportNumber]);
            $sport->setSubcategory("todo");
            $sport->setGender(false);

            $sportList[] = $sport;
        }

        for ($sportNumber = 0; $sportNumber < count($sportFaker); $sportNumber++) {
            $sport = new Sport;
            $manager->persist($sport);
            $sport->setCategory($sportFaker[$sportNumber]);
            $sport->setSubcategory("todo");
            $sport->setGender(true);

            $sportList[] = $sport;
        }

        for ($epreuveNumber = 0; $epreuveNumber < count($sportFaker); $epreuveNumber++) {
            $epreuve = new Epreuve;
            $manager->persist($epreuve);
            $epreuve->setCodeSport($sportList[$epreuveNumber]);
            $epreuve->setLocation($cityFaker[$faker->numberBetween(0, count($cityFaker) - 1)]);
            $epreuve->setName($sportFaker[$epreuveNumber] . " Homme");

            $epreuveMaleList[] = $epreuve;
        }

        for ($epreuveNumber = 0; $epreuveNumber < count($sportFaker); $epreuveNumber++) {
            $epreuve = new Epreuve;
            $manager->persist($epreuve);
            $epreuve->setCodeSport($sportList[$epreuveNumber]);
            $epreuve->setLocation($cityFaker[$faker->numberBetween(0, count($cityFaker) - 1)]);
            $epreuve->setName($sportFaker[$epreuveNumber] . " Femme");

            $epreuveFemaleList[] = $epreuve;
        }

        for ($eventNumber = 0; $eventNumber < $nbrEvent; $eventNumber++) {
            $event = new Event;
            $manager->persist($event);
            $event->setName($eventNameFaker[$eventNumber]);
            $event->setLocation($cityFaker[$faker->numberBetween(0, count($cityFaker) - 1)]);

            $eventList[] = $event;
        }

        for ($recordNumber = 0; $recordNumber < count($recordFaker) - 1; $recordNumber++) {
            $record = new Record;
            $manager->persist($record);
            $record->setTitle($recordFaker[$recordNumber]); 

            $recordList[] = $record;
        }

        for ($DelegationNumber = 1; $DelegationNumber < $nbrDelegation; $DelegationNumber++) {
            $delegation = new Delegation;
            $manager->persist($delegation);
            $country = $faker->country();
            $delegation->setName($country);

            $delegationList[] = $delegation;
            
            for ($athleteNumber = 0; $athleteNumber < $nbrAthlete; $athleteNumber++) {
                $athlete = new Athlete;
                $manager->persist($athlete);
                $athlete->setLastname($faker->lastName());
                $athlete->setFirstname($faker->firstNameMale());
                $athlete->setAge($faker->numberBetween(20, 40));
                $athlete->setImage("todo");
                $athlete->setGender(false);
                $athlete->setNationality($country);
                $athlete->setCodeDelegation($delegation);
                $athlete->setCity($cityFaker[$faker->numberBetween(0, count($cityFaker) - 1)]);
                if ($athlete->getCity() === "Marseille") {
                    $athlete->setFeature(true);
                    echo $athlete->getCity();
                    echo "helo";
                }
                $athlete->addEvent($eventList[$faker->numberBetween(0, count($eventList) - 1)]);
                $athlete->addEpreuve($epreuveMaleList[$faker->numberBetween(0, count($epreuveMaleList) - 1)]);
                $athlete->addRecord($recordList[$faker->numberBetween(0, count($recordList) - 1)]);

                $athleteList[] = $athlete;
            }

            for ($athleteNumber = 0; $athleteNumber < $nbrAthlete; $athleteNumber++) {
                $athlete = new Athlete;
                $manager->persist($athlete);
                $athlete->setLastname($faker->lastName());
                $athlete->setFirstname($faker->firstNameFemale());
                $athlete->setAge($faker->numberBetween(20, 40));
                $athlete->setImage("todo");
                $athlete->setGender(true);
                $athlete->setNationality($country);
                $athlete->setCodeDelegation($delegation);
                $athlete->setCity($cityFaker[$faker->numberBetween(0, count($cityFaker) - 1)]);
                $athlete->addEpreuve($epreuveFemaleList[$faker->numberBetween(0, count($epreuveFemaleList) - 1)]);

                $athleteList[] = $athlete;
            }
        }
            
        $manager->flush();
    }
}
