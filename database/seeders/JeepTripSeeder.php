<?php

namespace Database\Seeders;

use App\Models\JeepTrip\JeepTrip;
use App\Models\JeepTrip\JeepTripAvailability;
use App\Models\JeepTrip\JeepTripDestination;
use App\Models\JeepTrip\JeepTripExclude;
use App\Models\JeepTrip\JeepTripImage;
use App\Models\JeepTrip\JeepTripInclude;
use App\Models\JeepTrip\JeepTripSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JeepTripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jeepTrips = [
            [
                'kode' => 'JEEP-SUNRISE-01',
                'nama' => 'Sunrise Jeep Adventure',
                'zona' => 'sunrise',
                'durasi_jam' => 4,
                'jam_berangkat' => '03:00',
                'harga_weekday' => 350000,
                'harga_weekend' => 400000,
                'rating' => 4.8,
                'quota_per_hari' => 3,
                'destinations' => [
                    'Base Camp Dieng',
                    'Bukit Sikunir',
                    'Telaga Warna',
                    'Puncak Sunrise Point',
                ],
                'includes' => [
                    'Jeep Toyota Hardtop',
                    'Driver profesional berpengalaman',
                    'BBM (bensin)',
                    'Parkir di semua lokasi',
                    'Asuransi perjalanan',
                    'Air mineral',
                ],
                'excludes' => [
                    'Tiket masuk objek wisata',
                    'Makanan dan minuman tambahan',
                    'Tips untuk driver',
                    'Pakaian hangat (sangat direkomendasikan)',
                ],
                'slot' => [
                    'nama' => 'Sunrise',
                    'jam_mulai' => '03:00',
                    'jam_selesai' => '07:00',
                ],
                'deskripsi_singkat' => 'Nikmati keindahan matahari terbit dari puncak Dieng dengan jeep adventure',
                'deskripsi_lengkap' => 'Rasakan pengalaman unik menyaksikan matahari terbit dari ketinggian Dieng Plateau. Perjalanan jeep adventure ini akan membawa Anda melalui jalur-jalur menantang dan pemandangan spektakuler sebelum matahari terbit.',
            ],
            [
                'kode' => 'JEEP-FAVORIT-01',
                'nama' => 'Zona Favorit Jeep Tour',
                'zona' => 'favorit',
                'durasi_jam' => 6,
                'jam_berangkat' => '08:00',
                'harga_weekday' => 450000,
                'harga_weekend' => 500000,
                'rating' => 4.6,
                'quota_per_hari' => 5,
                'destinations' => [
                    'Kompleks Candi Arjuna',
                    'Telaga Warna',
                    'Kebun Strawberry Dieng',
                    'Bukit Sikunir',
                    'Watu Kendil',
                ],
                'includes' => [
                    'Jeep Toyota Hardtop',
                    'Driver profesional',
                    'BBM (bensin)',
                    'Parkir di semua lokasi',
                    'Asuransi perjalanan',
                    'Air mineral',
                    'Tiket masuk Kompleks Candi',
                ],
                'excludes' => [
                    'Tiket masuk Telaga Warna',
                    'Makanan dan minuman',
                    'Tips untuk driver',
                    'Souvenir',
                ],
                'slot' => [
                    'nama' => 'Pagi',
                    'jam_mulai' => '08:00',
                    'jam_selesai' => '14:00',
                ],
                'deskripsi_singkat' => 'Eksplorasi destinasi favorit Dieng dengan jeep adventure',
                'deskripsi_lengkap' => 'Jelajahi tempat-tempat paling populer di Dieng dengan jeep. Dari kompleks candi kuno, telaga warna, hingga kebun strawberry, semua dalam satu paket lengkap.',
            ],
            [
                'kode' => 'JEEP-FULLDAY-01',
                'nama' => 'Full Day Jeep Adventure',
                'zona' => 'full-day',
                'durasi_jam' => 8,
                'jam_berangkat' => '07:00',
                'harga_weekday' => 650000,
                'harga_weekend' => 700000,
                'rating' => 4.9,
                'quota_per_hari' => 2,
                'destinations' => [
                    'Kompleks Candi Arjuna',
                    'Telaga Warna',
                    'Kebun Strawberry',
                    'Bukit Sikunir',
                    'Watu Kendil',
                    'Dieng Plateau View',
                ],
                'includes' => [
                    'Jeep Toyota Hardtop',
                    'Driver profesional',
                    'BBM (bensin)',
                    'Parkir di semua lokasi',
                    'Asuransi perjalanan',
                    'Air mineral',
                    'Makan siang prasmanan',
                    'Tiket masuk semua objek',
                ],
                'excludes' => [
                    'Minuman tambahan',
                    'Tips untuk driver',
                    'Souvenir',
                    'Pakaian ganti',
                ],
                'slot' => [
                    'nama' => 'Full Day',
                    'jam_mulai' => '07:00',
                    'jam_selesai' => '15:00',
                ],
                'deskripsi_singkat' => 'Petualangan jeep seharian mengeksplorasi seluruh Dieng',
                'deskripsi_lengkap' => 'Paket lengkap untuk mengeksplorasi seluruh pesona Dieng dalam satu hari. Dari pagi hingga sore, Anda akan mengunjungi semua spot menarik dengan jeep adventure.',
            ],
        ];

        $createdCount = 0;
        $skippedCount = 0;

        foreach ($jeepTrips as $tripData) {
            DB::beginTransaction();

            try {
                // Check if this specific jeep trip already exists
                if (JeepTrip::where('kode', $tripData['kode'])->exists()) {
                    $this->command->info("Jeep Trip {$tripData['kode']} already exists. Skipping.");
                    $skippedCount++;
                    continue;
                }

                // Create the jeep trip
                $jeepTrip = JeepTrip::create([
                    'kode' => $tripData['kode'],
                    'slug' => Str::slug($tripData['nama']),
                    'nama_paket' => $tripData['nama'],
                    'deskripsi_singkat' => $tripData['deskripsi_singkat'],
                    'deskripsi_lengkap' => $tripData['deskripsi_lengkap'],
                    'zona' => $tripData['zona'],
                    'durasi_jam' => $tripData['durasi_jam'],
                    'kapasitas_ideal_per_jeep' => 4,
                    'kapasitas_max_per_jeep' => 4,
                    'harga_weekday' => $tripData['harga_weekday'],
                    'harga_weekend' => $tripData['harga_weekend'],
                    'rating' => $tripData['rating'],
                    'is_active' => true,
                ]);

                // Create destinations
                $destinations = [];
                foreach ($tripData['destinations'] as $index => $dest) {
                    $destinations[] = [
                        'nama_destinasi' => $dest,
                        'urutan' => $index + 1,
                    ];
                }
                $jeepTrip->destinations()->createMany($destinations);

                // Create includes
                $includes = [];
                foreach ($tripData['includes'] as $item) {
                    $includes[] = ['nama_item' => $item];
                }
                $jeepTrip->includes()->createMany($includes);

                // Create excludes
                $excludes = [];
                foreach ($tripData['excludes'] as $item) {
                    $excludes[] = ['nama_item' => $item];
                }
                $jeepTrip->excludes()->createMany($excludes);

                // Create slot
                $slot = $jeepTrip->slots()->create([
                    'nama_slot' => $tripData['slot']['nama'],
                    'jam_mulai' => $tripData['slot']['jam_mulai'],
                    'jam_selesai' => $tripData['slot']['jam_selesai'],
                    'is_active' => true,
                ]);

                // Create availabilities for 30 days ahead
                $this->createAvailabilitiesForSlot($slot, 30, $tripData['quota_per_hari']);

                DB::commit();

                $this->command->info("Jeep Trip {$tripData['kode']} created successfully!");
                $createdCount++;

            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error("Error creating Jeep Trip {$tripData['kode']}: " . $e->getMessage());
                throw $e;
            }
        }

        if ($createdCount > 0) {
            $this->command->info("Seeding completed: {$createdCount} created, {$skippedCount} skipped.");
        } else {
            $this->command->info("All Jeep Trip data already exists. No new data created.");
        }
    }

    private function createAvailabilitiesForSlot(JeepTripSlot $slot, int $daysAhead, int $quotaPerDay)
    {
        for ($i = 0; $i < $daysAhead; $i++) {
            $date = now()->addDays($i)->toDateString();

            JeepTripAvailability::create([
                'jeep_trip_slot_id' => $slot->id,
                'tanggal' => $date,
                'quota_jeep' => $quotaPerDay,
                'quota_terpakai' => 0,
                'is_closed' => false,
            ]);
        }
    }
}
