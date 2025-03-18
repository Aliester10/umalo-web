<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_parameter')->insert([
            [
                'email' => 'business@umalo.id',
                'no_wa' => '+62 852-8265-1911',
                'address' => 'Jl. Raya Tapos, Tapos, Kec. Tapos, Kota Depok, Jawa Barat',
                'maps_url' => 'https://www.google.com/maps?sca_esv=3f65f6f3feeae64f&output=search&q=pt+umalo+sedia+tekno&source=lnms&fbs=AEQNm0CTI4ghiYmMI-A67QciKvwhEVBEZaKMmvvXvCV-ZrcsMPi4YWwkfu5lQxY108RCUk2A_m8gO_ISgv-gCJ82B6zCb6HtbTHANDEzoKqcZ2g5pm-JzhOJN-iTd2G4NwUHqE7OCdqxUZxnM_ThKydmHz-uSv9TpYVoiVSGDRjrw-f1LtntjSfrDN4ZoijHOwBTCsya34T_F61no7XdueoR8_OaqtmdQA&entry=mc&ved=1t:200715&ictx=111',
                'maps_iframe' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4878.52474144665!2d106.88870677499206!3d-6.423678593567295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69eb0044466dfd%3A0x53b2670619207624!2sPT%20UMALO%20SEDIA%20TEKNO!5e1!3m2!1sid!2sid!4v1734859855897!5m2!1sid!2sid',
                'visi' => 'To be a global leader in smart technology and IT solutions, continuously pushing the boundaries of innovation and transforming the digital landscape.',
                'misi' => 'To deliver state-of-the-art IT and smart technology solutions that empower businesses to achieve operational excellence and competitive advantage.',
                'linkedin' => 'https://www.linkedin.com/company/pt-umalo-sedia-tekno',
                'ekatalog' => 'https://e-katalog.lkpp.go.id/info/penyedia/1065334?komoditasId=90424',
                'company_name' => 'PT Umalo Sedia Tekno',
                'short_history' => 'PT. Umalo Sedia Tekno is an industry leader in providing innovative IT solutions and smart technology systems. Established in 2023, we specialize in integrating cutting-edge technologies to streamline operations, enhance security, and foster innovation across various industries. Our commitment to excellence and innovation has positioned us at the forefront of the smart technology revolution',
            ]
        ]);
    }
}