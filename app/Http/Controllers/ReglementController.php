<?php

namespace App\Http\Controllers;

class ReglementController extends Controller
{
    public function __invoke()
    {
        $event = config('event.event');

        $articles = [
            [
                'title' => 'Participation et inscription',
                'rules' => [
                    "Chaque équipe est composée de {$event['teamSize']} joueurs titulaires, et peut compter jusqu'à {$event['substitutes']} remplaçants.",
                    "L'inscription se fait exclusivement depuis ce site, avec une connexion Discord obligatoire. Le compte utilisé pour l'inscription est celui du chef d'équipe.",
                    "Un joueur ne peut appartenir qu'à une seule équipe pour toute la durée de l'event.",
                    "Toute inscription est vérifiée par le staff avant d'être validée. Une inscription incomplète, en doublon ou fantaisiste peut être refusée sans justification.",
                    "Les inscriptions ferment le 4 septembre 2026. Passé cette date, aucune nouvelle équipe n'est acceptée.",
                    "Toute modification de composition après l'inscription doit passer par le staff, sur le Discord Alpha.",
                ],
            ],
            [
                'title' => "Déroulement de l'event",
                'rules' => [
                    "L'event se déroule du 5 au 13 septembre 2026. La Cité ouvre à l'issue de la cérémonie d'ouverture, le samedi 5 septembre à 20h45.",
                    "La présence à la cérémonie d'ouverture est fortement recommandée : les règles détaillées et le barème de points y sont présentés.",
                    "Les horaires des events du soir sont annoncés sur le Discord Alpha. Une équipe absente à un event ne marque simplement aucun point sur cette épreuve.",
                    "Le staff se réserve le droit d'ajuster le planning ou les règles d'un event en cours de semaine, avec annonce préalable sur le Discord.",
                ],
            ],
            [
                'title' => 'Comportement et fair-play',
                'rules' => [
                    "Le respect entre joueurs est la règle de base. Insultes, harcèlement, propos discriminatoires ou provocations répétées entraînent une sanction immédiate.",
                    "La compétition est encouragée, la toxicité ne l'est pas. Le trash-talk bon enfant est toléré tant qu'il reste dans le cadre du jeu.",
                    "Toute forme de menace, de doxxing ou de contact malveillant en dehors du jeu entraîne une exclusion définitive et un signalement.",
                    "Les décisions du staff sont souveraines pendant l'event. Les contestations se font calmement, via le chef d'équipe, après l'épreuve concernée.",
                ],
            ],
            [
                'title' => 'Triche et logiciels tiers',
                'rules' => [
                    "Tout client modifié apportant un avantage compétitif est interdit : X-ray, fly, kill aura, auto-clicker, macro, radar, minimap révélant les entités ou les minerais.",
                    "Les ressource packs de type X-ray ou rendant les blocs transparents sont assimilés à de la triche.",
                    "L'exploitation volontaire d'un bug du serveur (duplication d'items, passage hors zone, contournement d'une limite) est interdite. Tout bug découvert doit être signalé au staff.",
                    "Les macros et scripts d'automatisation de farm sont interdits, y compris pendant les périodes creuses.",
                    "Le staff peut demander un screenshare à tout moment. Un refus est traité comme un aveu de triche.",
                    "La triche d'un seul joueur engage toute son équipe.",
                ],
            ],
            [
                'title' => 'Jeu, constructions et territoires',
                'rules' => [
                    "La home base de chaque équipe est définie par son chef en début d'event à l'aide de l'item prévu à cet effet.",
                    "Le griefing des constructions d'une autre équipe est interdit, sauf mention explicite du contraire dans le cadre d'un event.",
                    "Le vol dans les coffres d'une autre équipe est interdit en dehors des events qui l'autorisent explicitement.",
                    "Le PvP est autorisé uniquement dans le cadre des events qui le prévoient. Le PvP sauvage en dehors de ces moments est sanctionné.",
                    "Les constructions des zones communes (Capitale, ONU, spawn) ne doivent pas être dégradées.",
                    "Le multi-compte est interdit : un joueur, un compte, une équipe.",
                ],
            ],
            [
                'title' => 'Économie, shop et points',
                'rules' => [
                    "Le shop se réinitialise chaque jour à minuit. Les prix et items affichés à un instant T font foi.",
                    "Les Alpha Coins ne comptent dans le score de l'équipe qu'une fois déposés en banque.",
                    "Les échanges de coins ou d'items entre équipes différentes sont interdits : chaque équipe joue avec ce qu'elle produit.",
                    "Toute manipulation visant à fausser l'économie (entente entre équipes, transferts déguisés) entraîne une annulation des points concernés.",
                    "Le barème détaillé de points est présenté à la cérémonie d'ouverture et fait référence en cas de litige.",
                ],
            ],
            [
                'title' => 'Diffusion et enregistrement',
                'rules' => [
                    "Les cérémonies d'ouverture et de clôture sont diffusées en live. En participant, vous acceptez que votre pseudo, votre skin et vos actions en jeu y apparaissent.",
                    "Les extraits de l'event peuvent être réutilisés par l'organisation pour la communication (best-of, rediffusion, réseaux sociaux).",
                    "Les joueurs sont libres de streamer ou d'enregistrer leur propre point de vue, dans le respect du règlement du serveur.",
                    "Le stream-sniping (utiliser le live d'un adversaire pour prendre un avantage) est interdit et sanctionné.",
                ],
            ],
            [
                'title' => 'Sanctions',
                'rules' => [
                    "Selon la gravité, le staff peut appliquer : un avertissement, un retrait de points, l'exclusion d'un joueur, ou la disqualification de l'équipe entière.",
                    "Un avertissement est notifié au chef d'équipe, qui est responsable de sa transmission au groupe.",
                    "Une triche avérée entraîne la disqualification immédiate de l'équipe, sans remboursement des points accumulés.",
                    "En cas de récidive, une exclusion du serveur au-delà de l'event peut être prononcée.",
                    "Les sanctions sont consignées et communiquées de manière transparente aux équipes concernées.",
                ],
            ],
            [
                'title' => 'Litiges et cas non prévus',
                'rules' => [
                    "Toute situation non couverte par ce règlement est tranchée par le staff, au cas par cas, dans l'esprit de l'event.",
                    "Les réclamations passent par le chef d'équipe, sur le Discord Alpha, et doivent être formulées dans les 24 heures suivant les faits.",
                    "Le règlement peut être précisé ou complété en cours d'event. Toute modification est annoncée sur le Discord Alpha et sur cette page.",
                    "S'inscrire à la Cité des Cristaux vaut acceptation pleine et entière de ce règlement.",
                ],
            ],
        ];

        return view('pages.reglement', [
            'event' => $event,
            'articles' => $articles,
        ]);
    }
}
