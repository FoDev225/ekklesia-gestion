<?php
// app/Services/ServiceMessageGenerator.php

namespace App\Services;

use App\Models\Service;
use Carbon\Carbon;

class ServiceMessageGenerator
{
    public static function generate()
    {
        $nextSunday = Carbon::now()->next(Carbon::SUNDAY);

        $service = Service::with([
            'assignments.role',
            'assignments.believer',
            'assignments.group'
        ])
        ->whereDate('service_date', $nextSunday)
        ->first();

        if (!$service) return null;

        $assignments = $service->assignments;

        $preacher = optional($assignments->firstWhere('role.code','preacher'))->believer->firstname ?? '-';
        $president = optional($assignments->firstWhere('role.code','president'))->believer->firstname ?? '-';
        $announcer = optional($assignments->firstWhere('role.code','announcements'))->believer->firstname ?? '-';

        $groups = $assignments->where('role.code','worship')
            ->pluck('group.name')
            ->implode(', ');

        $message = "📅 PROGRAMME DU CULTE – " . $nextSunday->format('d/m/Y') . "\n\n";
        $message .= "📖 Thème : " . ($service->service_theme ?? '-') . "\n\n";
        $message .= "👤 Prédicateur : $preacher\n";
        $message .= "👔 Président : $president\n";
        $message .= "🎶 Louange : $groups\n";
        $message .= "📢 Annonces : $announcer\n\n";

        $message .= "🙏 Le Président, le Pasteur et l’Annonceur sont priés de renseigner la plateforme dans les délais requis. Chaque acteur est encouragé à consulter la plateforme avant le début du culte afin d’assurer une meilleure fluidité du déroulement." . "\n\n";
        $message .= "Travaillons avec excellence pour la gloire du Seigneur Jésus-Christ." . "\n\n";
        $message .= "La Direction des Cultes";

        return $message;
    }
}