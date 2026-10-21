<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'parent_id',
        'slug',
    ];

    /**
     * Get the parent district of this local area.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the child local areas for this district.
     */
    public function areas(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('name');
    }

    /**
     * Scope query to only districts.
     */
    public function scopeDistricts(Builder $query): Builder
    {
        return $query->where('type', 'district');
    }

    /**
     * Scope query to only local areas.
     */
    public function scopeAreas(Builder $query): Builder
    {
        return $query->where('type', 'area');
    }

    /**
     * Handle dynamic static method calls into the model.
     * Allows Location::areas() to forward to the scopeAreas builder query.
     */
    /**
     * Return the canonical 25 districts and their local areas.
     */
    public static function getHierarchy(): array
    {
        return [
            'Ampara' => ['Ampara', 'Kalmunai', 'Akkaraipattu', 'Sammanthurai', 'Pottuvil', 'Sainthamaruthu', 'Uhana', 'Maha Oya', 'Dehiattakandiya', 'Nintavur', 'Oluvil', 'Thirukkovil'],
            'Anuradhapura' => ['Anuradhapura', 'Kekirawa', 'Thambuttegama', 'Eppawala', 'Medawachchiya', 'Mihintale', 'Nochchiyagama', 'Galenbindunuwewa', 'Horowpothana', 'Talawa', 'Kahatagasdigiliya', 'Rajanganaya'],
            'Badulla' => ['Badulla', 'Bandarawela', 'Ella', 'Haputale', 'Welimada', 'Mahiyanganaya', 'Passara', 'Hali-Ela', 'Diyatalawa', 'Haldummulla', 'Lunugala', 'Meegahakiula'],
            'Batticaloa' => ['Batticaloa', 'Kattankudy', 'Eravur', 'Valaichchenai', 'Kalkudah', 'Chenkalady', 'Kaluwanchikudy', 'Vakarai', 'Arayampathy', 'Oddamavadi'],
            'Colombo' => ['Colombo', 'Dehiwala', 'Mount Lavinia', 'Nugegoda', 'Maharagama', 'Kotte', 'Kaduwela', 'Homagama', 'Piliyandala', 'Moratuwa', 'Avissawella', 'Hanwella', 'Malabe', 'Rajagiriya', 'Boralesgamuwa'],
            'Galle' => ['Galle', 'Hikkaduwa', 'Ambalangoda', 'Elpitiya', 'Baddegama', 'Karapitiya', 'Ahangama', 'Balapitiya', 'Bentota', 'Imaduwa', 'Udugama', 'Nagoda', 'Yakkalamulla'],
            'Gampaha' => ['Gampaha', 'Negombo', 'Veyangoda', 'Nittambuwa', 'Kiribathgoda', 'Kadawatha', 'Ja-Ela', 'Wattala', 'Minuwangoda', 'Divulapitiya', 'Kelaniya', 'Ragama', 'Ganemulla', 'Katunayake', 'Mirigama'],
            'Hambantota' => ['Hambantota', 'Tangalle', 'Beliatta', 'Tissamaharama', 'Ambalantota', 'Walasmulla', 'Weeraketiya', 'Middeniya', 'Suriyawewa', 'Lunugamvehera', 'Kirinda', 'Ranna'],
            'Jaffna' => ['Jaffna', 'Nallur', 'Chavakachcheri', 'Point Pedro', 'Valvettithurai', 'Kopay', 'Tellippalai', 'Chankanai', 'Karainagar', 'Kayts', 'Atchuvely', 'Kodikamam'],
            'Kalutara' => ['Kalutara', 'Panadura', 'Horana', 'Matugama', 'Beruwala', 'Aluthgama', 'Bandaragama', 'Wadduwa', 'Payagala', 'Ingiriya', 'Bulathsinhala', 'Millaniya', 'Agalawatta'],
            'Kandy' => ['Kandy', 'Peradeniya', 'Gampola', 'Katugastota', 'Kundasale', 'Kadugannawa', 'Wattegama', 'Nawalapitiya', 'Digana', 'Akurana', 'Galagedara', 'Pussellawa', 'Teldeniya', 'Pilimathalawa'],
            'Kegalle' => ['Kegalle', 'Mawanella', 'Rambukkana', 'Warakapola', 'Ruwanwella', 'Yatiyantota', 'Dehiowita', 'Deraniyagala', 'Galigamuwa', 'Bulathkohupitiya', 'Aranayaka'],
            'Kilinochchi' => ['Kilinochchi', 'Paranthan', 'Poonakary', 'Pallai', 'Akkarayankulam', 'Uruthirapuram', 'Kandawalai'],
            'Kurunegala' => ['Kurunegala', 'Kuliyapitiya', 'Narammala', 'Pannala', 'Wariyapola', 'Nikaweratiya', 'Mawathagama', 'Polgahawela', 'Bingiriya', 'Alawwa', 'Galgamuwa', 'Ibbagamuwa', 'Melsiripura', 'Rideegama'],
            'Mannar' => ['Mannar', 'Pesalai', 'Talaimannar', 'Murunkan', 'Madhu', 'Nanaddan', 'Erukkalampiddy'],
            'Matale' => ['Matale', 'Dambulla', 'Galewela', 'Ukuwela', 'Naula', 'Rattota', 'Yatawatta', 'Pallepola', 'Sigiriya', 'Laggala', 'Wilgamuwa'],
            'Matara' => ['Matara', 'Weligama', 'Akuressa', 'Kamburupitiya', 'Hakmana', 'Dikwella', 'Deniyaya', 'Kotapola', 'Gandara', 'Devinuwara', 'Kirinda Puhulwella', 'Malimbada'],
            'Monaragala' => ['Monaragala', 'Wellawaya', 'Buttala', 'Bibile', 'Siyambalanduwa', 'Kataragama', 'Thanamalwila', 'Badalkumbura', 'Medagama', 'Okkampitiya'],
            'Mullaitivu' => ['Mullaitivu', 'Puthukkudiyiruppu', 'Oddusuddan', 'Maritimepattu', 'Thunukkai', 'Mallavi', 'Kokkilai'],
            'Nuwara Eliya' => ['Nuwara Eliya', 'Hatton', 'Talawakele', 'Ginigathhena', 'Nanu Oya', 'Kotagala', 'Lindula', 'Maskeliya', 'Ragala', 'Walapane', 'Hanguranketha', 'Ambagamuwa'],
            'Polonnaruwa' => ['Polonnaruwa', 'Hingurakgoda', 'Kaduruwela', 'Medirigiriya', 'Welikanda', 'Lankapura', 'Aralaganwila', 'Bakamuna', 'Dimbulagala'],
            'Puttalam' => ['Puttalam', 'Chilaw', 'Wennappuwa', 'Marawila', 'Nattandiya', 'Anamaduwa', 'Dankotuwa', 'Kalpitiya', 'Madampe', 'Mundel', 'Norochcholai', 'Mahawewa'],
            'Ratnapura' => ['Ratnapura', 'Balangoda', 'Embilipitiya', 'Pelmadulla', 'Eheliyagoda', 'Kuruwita', 'Kahawatta', 'Godakawela', 'Rakwana', 'Kalawana', 'Nivitigala', 'Kolonna'],
            'Trincomalee' => ['Trincomalee', 'Kinniya', 'Kantale', 'Nilaveli', 'Mutur', 'China Bay', 'Thampalakamam', 'Kuchchaveli', 'Seruwila', 'Pulmoddai'],
            'Vavuniya' => ['Vavuniya', 'Omanthai', 'Cheddikulam', 'Nedunkeni', 'Puwarasankulam', 'Settikulam'],
        ];
    }
}
