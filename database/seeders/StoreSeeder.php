<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
   /**
    * Run the database seeds.
    */
   public function run(): void
   {
      $store_list = [
         ['code' => 'C001', 'name' => 'SERENDRA', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C002', 'name' => 'TRINOMA', 'type' => 1, 'area' => 'North'],
         ['code' => 'C003', 'name' => 'ALABANG TOWN CENTER', 'type' => 1, 'area' => 'South'],
         ['code' => 'C004', 'name' => 'ROCKWELL BUSINESS CENTER', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C005', 'name' => 'GREENBELT 2', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C006', 'name' => 'LUCKY CHINA TOWN', 'type' => 1, 'area' => 'South'],
         ['code' => 'C007', 'name' => 'SM North EDSA', 'type' => 1, 'area' => 'North'],
         ['code' => 'C008', 'name' => 'STEPS', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C009', 'name' => 'SM AURA', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C010', 'name' => 'SMBF', 'type' => 1, 'area' => 'South'],
         ['code' => 'C011', 'name' => 'AYALA FAIRVIEW TERRACES', 'type' => 1, 'area' => 'North'],
         ['code' => 'C012', 'name' => 'GATEWAY', 'type' => 1, 'area' => 'North'],
         ['code' => 'C013', 'name' => 'ST. LUKES', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C014', 'name' => 'SHANGRI-LA MALL', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C015', 'name' => 'CENTURY CITY MALL', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C016', 'name' => 'SM FAIRVIEW', 'type' => 1, 'area' => 'North'],
         ['code' => 'C017', 'name' => 'NAIA TERMINAL 3', 'type' => 1, 'area' => 'South'],
         ['code' => 'C018', 'name' => 'ENTERPRISE', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C019', 'name' => 'ESTANCIA', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C020', 'name' => 'UPTOWN BGC', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C021', 'name' => 'SM MANILA', 'type' => 1, 'area' => 'South'],
         ['code' => 'C022', 'name' => 'VENETIAN MALL', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C023', 'name' => 'MAAX', 'type' => 1, 'area' => 'South'],
         ['code' => 'C024', 'name' => 'UNIMART', 'type' => 1, 'area' => 'North'],
         ['code' => 'C025', 'name' => 'FESTIVAL', 'type' => 1, 'area' => 'South'],
         ['code' => 'C026', 'name' => 'SM SAN LAZARO', 'type' => 1, 'area' => 'North'],
         ['code' => 'C027', 'name' => 'SM MALL OF ASIA', 'type' => 1, 'area' => 'South'],
         ['code' => 'C028', 'name' => 'ROB GALLERIA', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C029', 'name' => 'SouthWOODS', 'type' => 1, 'area' => 'South'],
         ['code' => 'C030', 'name' => 'AYALA FELIZ', 'type' => 1, 'area' => 'North'],
         ['code' => 'C031', 'name' => 'POWERPLANT MALL', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C032', 'name' => 'SM SouthMALL', 'type' => 1, 'area' => 'South'],
         ['code' => 'C033', 'name' => 'ROB PLACE MIDTOWN', 'type' => 1, 'area' => 'South'],
         ['code' => 'C034', 'name' => 'EASTWOOD', 'type' => 1, 'area' => 'North'],
         ['code' => 'C035', 'name' => 'ONE BONIFACIO HIGH STREET', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C036', 'name' => 'U.P. TOWN CENTER', 'type' => 1, 'area' => 'North'],
         ['code' => 'C037', 'name' => 'ROBINSONS MAGNOLIA', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C038', 'name' => 'ROB GALLERIA South', 'type' => 1, 'area' => 'South'],
         ['code' => 'C039', 'name' => 'SM EAST ORTIGAS', 'type' => 1, 'area' => 'North'],
         ['code' => 'C040', 'name' => 'SM MARIKINA', 'type' => 1, 'area' => 'North'],
         ['code' => 'C041', 'name' => 'RESORTS WORLD MANILA', 'type' => 1, 'area' => 'South'],
         ['code' => 'C042', 'name' => 'PROMENADE', 'type' => 1, 'area' => 'North'],
         ['code' => 'C043', 'name' => 'AYALA 30TH', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C044', 'name' => 'BAYMALL', 'type' => 1, 'area' => 'South'],
         ['code' => 'C045', 'name' => 'AYALA MALLS CLOVERLEAF', 'type' => 1, 'area' => 'North'],
         ['code' => 'C046', 'name' => 'SM MAKATI', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C048', 'name' => 'AMPHITHEATHER', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C049', 'name' => 'NEW CLARK', 'type' => 1, 'area' => 'North'],
         ['code' => 'C050', 'name' => 'SM SUCAT', 'type' => 1, 'area' => 'South'],
         ['code' => 'C051', 'name' => 'CITY OF DREAMS', 'type' => 1, 'area' => 'South'],
         ['code' => 'C052', 'name' => 'ROB TAGAYTAY', 'type' => 1, 'area' => 'South'],
         ['code' => 'C053', 'name' => 'NUVALI SOLENAD', 'type' => 1, 'area' => 'South'],
         ['code' => 'C054', 'name' => 'TWINLAKES', 'type' => 1, 'area' => 'South'],
         ['code' => 'C055', 'name' => 'SM G. CENTRAL', 'type' => 1, 'area' => 'North'],
         ['code' => 'C056', 'name' => 'STA. MESA', 'type' => 1, 'area' => 'MFO'],
         ['code' => 'C057', 'name' => 'SM MASINAG', 'type' => 1, 'area' => 'North'],
         ['code' => 'C058', 'name' => 'ROBINSONS LA UNION', 'type' => 1, 'area' => 'North'],
         ['code' => 'C059', 'name' => 'SM BAGUIO', 'type' => 1, 'area' => 'North'],
         ['code' => 'C060', 'name' => 'SM TANZA', 'type' => 1, 'area' => 'South'],
         ['code' => 'C061', 'name' => 'OKADA', 'type' => 1, 'area' => 'South'],
         ['code' => 'C062', 'name' => 'SM PASIG', 'type' => 1, 'area' => 'MFO'],

         [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K001",
            "name"=> "GLORIETTA 4"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K002",
            "name"=> "ROCKWELL"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K003",
            "name"=> "RCBC"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K004",
            "name"=> "MOA"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K005",
            "name"=> "MAKATI MED"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K006",
            "name"=> "GATEWAY"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K007",
            "name"=> "MEGAMALL"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K009",
            "name"=> "CASH AND CARRY"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K011",
            "name"=> "SM SUCAT"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K012",
            "name"=> "AYALA 30TH"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K014",
            "name"=> "SM STA ROSA"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K015",
            "name"=> "DOUBLE DRAGON"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K016",
            "name"=> "AYALA CIRCUIT"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K017",
            "name"=> "SM BICUTAN"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K018",
            "name"=> "SM NORTH EDSA"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K019",
            "name"=> "ACL"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K020",
            "name"=> "WALTER MAKATI"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K021",
            "name"=> "ATC"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K022",
            "name"=> "CENTRAL SQUARE"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K023",
            "name"=> "FISHERMALL"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K024",
            "name"=> "VMALL"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K025",
            "name"=> "SHANGRILA"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K026",
            "name"=> "VERTIS"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K027",
            "name"=> "FESTIVAL"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K028",
            "name"=> "TRINOMA"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K029",
            "name"=> "SM BACOOR"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K030",
            "name"=> "SM PAMPANGA"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K031",
            "name"=> "SM MOLINO"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K032",
            "name"=> "SM MARILAO HYPERMARKET"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K033",
            "name"=> "ROBINSONS MALOLOS"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K034",
            "name"=> "WALTER NORTH EDSA"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K035",
            "name"=> "LCM"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K036",
            "name"=> "SM BALIWAG"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K037",
            "name"=> "MARQUEE MALL"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K038",
            "name"=> "SM CALAMBA"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K039",
            "name"=> "SM BATANGAS"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K040",
            "name"=> "ROB ANTIPOLO"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K041",
            "name"=> "SM VALENZUELA"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K042",
            "name"=> "WALTERMART MACAPAGAL"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K043",
            "name"=> "SM MARILAO ATRIUM"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K044",
            "name"=> "MARKET MARKET"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K045",
            "name"=> "ROBINSONS LIPA"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K046",
            "name"=> "AYALA BAYMALL"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K047",
            "name"=> "SM LIPA"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K048",
            "name"=> "SM CLARK"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K049",
            "name"=> "SM SOUTHMALL"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K050",
            "name"=> "ROBINSONS STARMILLS"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K051",
            "name"=> "SM OLONGAPO"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K053",
            "name"=> "SM TARLAC"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K054",
            "name"=> "SM TELABASTAGAN"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K055",
            "name"=> "SM PULILAN"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K056",
            "name"=> "SM TAYTAY B"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K057",
            "name"=> "SM SAN PABLO"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K058",
            "name"=> "SM DASMA"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K059",
            "name"=> "SM CABANATUAN"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K060",
            "name"=> "SM BAGUIO"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K061",
            "name"=> "ROB MAGNOLIA"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K062",
            "name"=> "SM ROSARIO"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K063",
            "name"=> "SM ROSALES"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K064",
            "name"=> "SM URDANETA"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K065",
            "name"=> "SM LUCENA"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K066",
            "name"=> "SM TAYTAY A"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "K067",
            "name"=> "THE PODIUM"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K068",
            "name"=> "SM TRECE"
        ],
        [
            "type"=> 0,
            "area"=> "SOUTH",
            "code"=> "K069",
            "name"=> "ROB GENTRI"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K070",
            "name"=> "SM SAN MATEO"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K071",
            "name"=> "EVER GOTESCO"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "K072",
            "name"=> "STA. LUCIA"
        ],
        [
            "type"=> 0,
            "area"=> "NORTH",
            "code"=> "",
            "name"=> "ROBINSONS CALASIAO"
        ],
        [
            "type"=> 0,
            "area"=> "MFO",
            "code"=> "",
            "name"=> "GLORIETTA 1"
        ]
      ];
      foreach ($store_list as $store) {
         Store::create([
            'code' => $store['code'],
            'name' => $store['name'],
            'type' => $store['type'],
            'area' => $store['area'],
            'audit_status' => 0,
            'created_at' => now(),
            'updated_at' => now(),
         ]);
      }
   }
}