<?php

use Illuminate\Database\Seeder;
use App\User;
use App\LoacalApplication;
use App\Functions;
use App\Certificate;
use App\UserCertificate;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'exports/users.csv';
        $admins = 'exports/admins.sql';
        $file = fopen($path, 'r');

        while (($line = fgetcsv($file)) !== FALSE) {
            $data = [
                'id' => '',
                'name' => '',
                'slug' => '',
                'email' => '',
                'created_at' => '',
            ];

            $i=0;
            $aCertificates=[];
            $aCap = Functions::maybe_unserialize($line[5]);
            $aCapConverted = [];
            unset($line[5]);

            foreach($data as $key=>$value){
                $data[$key] = $line[$i];
                $i++;
            }

            $data["password"] = "";
            $application = 0;

            foreach($aCap as $role => $value){
                if(!$value) continue;
                $oCert = NULL;
                switch($role){
                    case "administrator":
                        $aCapConverted[] = 2;
                        break;
                    case "wc_product_vendors_manager_vendor":
                        $aCapConverted[] = 4;
                        break;
                    case "wc_product_vendors_admin_vendor":
                        $aCapConverted[] = 4;
                        break;
                    case "wc_product_vendors_pending_vendor":
                        $application = 1;
                        $aCapConverted[] = 6;
                        break;
                    case "customer":
                        $aCapConverted[] = 6;
                        break;
                    default:
                        if($role == "pending") break;
                        $aTitle = explode("_",$role);

                        $oCert = Certificate::updateOrCreate([
                            "title" => implode(' ',explode("_",ucwords($role,"_"))),
                            "slug" => $role
                        ]);
                        $aCertificates[] = $oCert->id;

                }
            }
            $data["activated"] = 1;

            if(in_array($data["email"],config('app.super_admins'))){
                $aCapConverted = [1,2,3,4,5,6];
            }
            //print_r($data);
            //print_r($aCapConverted);
            $oUser = User::firstOrCreate($data);
            $oUser->initProfile();
            $oUser->detachAllRoles();
            $oUser->attachRoles($aCapConverted);

            if(count($aCertificates)){
                foreach($aCertificates as $certid)
                UserCertificate::updateOrCreate([
                    "user_id" => $oUser->id,
                    "certificate_id" => $certid
                ]);
            }

            if($application){
                LoacalApplication::firstOrCreate([
                    "user_id" => $oUser->getAttributes()["id"],
                    "applicant_message" => "[migrated from wordpress]"
                ]);
            }


        }
        fclose($file);
        DB::unprepared(file_get_contents($admins));
        $this->command->info('Admins seeded!');
    }
}

