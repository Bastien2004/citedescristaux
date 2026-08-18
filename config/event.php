<?php

/**
 * Source de vérité du contenu de l'event.
 * Modifie ce fichier pour mettre à jour le site (dates, planning, shop...).
 *
 * Équivalent Laravel de src/lib/event.ts — contenu identique, non modifié.
 */

return [

    'event' => [
        'name' => 'Cité des Cristaux — Alpha Games',
        'nameOver' => 'Cité des Cristaux',
        'nameMain' => 'Alpha Games',
        'server' => 'NationsGlory · Alpha',
        'organizer' => "l'équipe Ops du Alpha",
        'years' => '6 ans d\'Alpha',
        'tagline' => 'Une semaine. Une Cité. Une seule équipe gagnante.',
        'datesLabel' => 'Du 5 au 13 septembre 2026',
        'datesShort' => '5 au 13 septembre',
        'logo' => '',
        'discordInvite' => '',
        'registrationOpen' => '2026-08-26T18:00:00+02:00',
        'registrationClose' => '2026-09-04T23:59:00+02:00',
        'openingLive' => '2026-09-05T20:45:00+02:00',
        'teamSize' => 6,
        'substitutes' => 2,
        'capitaleImage' => '',
    ],

    'planning' => [
        [
            'date' => '5 sept.', 'weekday' => 'Samedi', 'time' => '20h45',
            'badge' => 'Live', 'live' => true, 'gold' => false, 'mystery' => false,
            'title' => "Cérémonie d'ouverture", 'watermark' => 'OUVERTURE',
            'description' => "Règles, présentation des équipes et du planning de la semaine. La Cité ouvre dans la foulée.",
        ],
        [
            'date' => '6 sept.', 'weekday' => 'Dimanche', 'time' => 'Le soir',
            'badge' => "Point à l'ONU", 'live' => false, 'gold' => false, 'mystery' => true,
            'title' => 'Event mystère', 'watermark' => '?',
            'description' => "Les scores actuels sont annoncés à l'ONU, puis l'event du soir est révélé.",
        ],
        [
            'date' => '7 sept.', 'weekday' => 'Lundi', 'time' => 'Event du soir',
            'badge' => null, 'live' => false, 'gold' => false, 'mystery' => false,
            'title' => 'Le dé à coudre', 'watermark' => 'DÉ',
            'description' => 'Le mini-jeu du soir à ne pas manquer sur la Cité.',
        ],
        [
            'date' => '8 sept.', 'weekday' => 'Mardi', 'time' => 'Nouveauté',
            'badge' => 'Nouveau monde', 'live' => false, 'gold' => false, 'mystery' => false,
            'title' => 'Ouverture du Nether', 'watermark' => 'NETHER',
            'description' => 'Accès au Nether et ouverture de son shop dédié.',
        ],
        [
            'date' => '9 sept.', 'weekday' => 'Mercredi', 'time' => 'Le soir',
            'badge' => 'Annoncé 1h avant', 'live' => false, 'gold' => false, 'mystery' => true,
            'title' => 'Event mystère', 'watermark' => '?',
            'description' => "Un event surprise dévoilé seulement 1h à l'avance.",
        ],
        [
            'date' => '10 sept.', 'weekday' => 'Jeudi', 'time' => 'Nouveauté',
            'badge' => 'Nouveau monde', 'live' => false, 'gold' => false, 'mystery' => false,
            'title' => 'Ouverture de la Lune', 'watermark' => 'LUNE',
            'description' => 'Accès à la Lune et ouverture de son shop dédié.',
        ],
        [
            'date' => '11 sept.', 'weekday' => 'Vendredi', 'time' => 'Le grand final',
            'badge' => 'Event final', 'live' => false, 'gold' => true, 'mystery' => false,
            'title' => 'Le Bingo', 'watermark' => 'BINGO',
            'description' => "L'event de clôture de la semaine. Tous les points sont en jeu.",
        ],
        [
            'date' => '12 sept.', 'weekday' => 'Samedi', 'time' => 'Diffusion live',
            'badge' => 'Live', 'live' => true, 'gold' => false, 'mystery' => false,
            'title' => 'Cérémonie de clôture', 'watermark' => 'CLÔTURE',
            'description' => 'Récap de la semaine. Les scores sont annoncés le lendemain.',
        ],
        [
            'date' => '13 sept.', 'weekday' => 'Dimanche', 'time' => 'Le verdict',
            'badge' => null, 'live' => false, 'gold' => false, 'mystery' => false,
            'title' => "Résultats à l'ONU", 'watermark' => 'ONU',
            'description' => "Annonce officielle des résultats de la Cité des Cristaux.",
        ],
    ],

    'pillars' => [
        [
            'key' => 'eco', 'title' => 'Économie évolutive', 'lead' => 'Le marché change chaque jour',
            'description' => "Chaque nuit à minuit, le shop se réinitialise : nouveaux items, nouveaux prix. Ce qui rapportait hier ne rapportera peut-être plus demain. À vous d'adapter votre farm en permanence.",
        ],
        [
            'key' => 'events', 'title' => 'Un event chaque soir', 'lead' => "L'esprit Alpha Games",
            'description' => "Un rendez-vous par soirée pendant toute la semaine : mini-jeux, events mystère annoncés à la dernière minute, ouvertures de nouveaux mondes, et le Bingo final.",
        ],
        [
            'key' => 'defis', 'title' => 'Défis en continu', 'lead' => 'Disponibles 24h/24',
            'description' => "Chasse aux têtes, parkours à répéter, défis cachés dans la Capitale. Aucun temps mort : il y a toujours des points à aller chercher, même à 4h du matin.",
        ],
    ],

    'shopCategories' => ['Minerais', 'Loot', 'Blocs déco', 'Nether', 'Lune'],

    'stats' => [
        ['value' => '9', 'label' => "jours d'event"],
        ['value' => '6', 'label' => 'joueurs par équipe'],
        ['value' => '5', 'label' => 'catégories de shop'],
        ['value' => '1', 'label' => 'équipe gagnante'],
    ],

];
