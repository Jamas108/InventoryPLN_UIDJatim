<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class BarangMasukChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($totalBarangPerKategori)
    {
        return $this->chart->lineChart()
            ->setTitle('Barang Masuk per Kategori')
            ->addData('Jumlah Barang Masuk', $totalBarangPerKategori->values())
            ->setLabels($totalBarangPerKategori->keys());
    }
}
