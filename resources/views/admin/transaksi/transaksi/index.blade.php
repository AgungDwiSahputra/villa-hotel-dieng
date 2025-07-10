<x-app-layout title="Transaksi" subTitle="Transaksi">
    <x-card-component col="12" title="Data Transaksi" :dataTable="$dataTable"/>

    @include('admin.transaksi.transaksi.create')
</x-app-layout>