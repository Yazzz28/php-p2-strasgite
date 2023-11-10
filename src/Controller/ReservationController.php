<?php

namespace App\Controller;

use App\Model\ReservationManager;

class ReservationController extends AbstractController
{
    public function index(): string
    {

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $reservation = array_map('trim', $_POST);
            if ($reservation['lastname'] === "") {
                $errors['lastname'] = "veuillez remplir votre nom";
            }
            if ($reservation['firstname'] === "") {
                $errors['firstname'] = "veuillez remplir votre Prénom";
            }
            if (!isset($reservation['chambre']) || $reservation['chambre'] === "") {
                $errors['chambre'] = "Veuillez choisir une chambre.";
            }
            if (strlen($reservation['demands']) > 255) {
                $errors['demands'] = "Les spécifités demandées sont trop longues (max 255 caractères).";
            }
            if (empty($errors)) {
                $reservationManager = new ReservationManager();
                $reservationManager->insert($reservation);
                header('Location: /');
            }
        }

        return $this->twig->render('reservation/_reservation.html.twig', [
            'errors' => $errors
        ]);
    }
}
