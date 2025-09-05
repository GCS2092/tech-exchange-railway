<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DashboardExport implements FromArray, WithHeadings, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return [
            ['Statistiques Générales'],
            ['Utilisateurs totaux', $this->data['stats']['total_users']],
            ['Produits totaux', $this->data['stats']['total_products']],
            ['Commandes totales', $this->data['stats']['total_orders']],
            ['Troc totaux', $this->data['stats']['total_trades']],
            ['Revenus totaux', number_format($this->data['stats']['total_revenue'], 0, ',', ' ') . ' FCFA'],
            [''],
            ['Statistiques du Mois'],
            ['Nouveaux utilisateurs', $this->data['monthly_stats']['new_users']],
            ['Nouvelles commandes', $this->data['monthly_stats']['new_orders']],
            ['Commandes complétées', $this->data['monthly_stats']['completed_orders']],
            ['Revenus du mois', number_format($this->data['monthly_stats']['monthly_revenue'], 0, ',', ' ') . ' FCFA'],
            ['Nouveaux trocs', $this->data['monthly_stats']['new_trades']],
        ];
    }

    public function headings(): array
    {
        return [
            'Métrique',
            'Valeur'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            8 => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }
} 