<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVerification;
use App\Models\SiteSetting;
use App\Models\Banner;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Roles & Users
        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'System Administrator with full permissions',
        ]);

        $operatorRole = Role::create([
            'name' => 'operator1',
            'description' => 'Operational Manager for managing products and verifications',
        ]);

        $adminUser = User::create([
            'name' => 'Zerox Admin',
            'email' => 'admin@zzerox.com',
            'password' => Hash::make('AdminPass@2026'),
            'email_verified_at' => now(),
        ]);
        $adminUser->roles()->attach($adminRole);

        $operatorUser = User::create([
            'name' => 'Zerox Operator',
            'email' => 'operator@zzerox.com',
            'password' => Hash::make('OperatorPass@2026'),
            'email_verified_at' => now(),
        ]);
        $operatorUser->roles()->attach($operatorRole);

        // 2. Seed Parent & Sub Categories (13 Subcategories Total)
        $categoriesData = [
            [
                'name' => 'Tablets',
                'description' => 'Pharmaceutical grade oral tablets produced under strict GMP standards.',
                'order' => 1,
                'image' => 'img/tablets-icon.png',
                'children' => [
                    ['name' => 'Anabolic Tablets', 'desc' => 'Oral anabolic androgenic tablets engineered for protein synthesis and nitrogen retention.'],
                    ['name' => 'Metabolic & Fat Burners', 'desc' => 'Thermogenic and thyroid metabolic regulation tablets for fat oxidation.'],
                    ['name' => 'PCT & Recovery Tablets', 'desc' => 'Post-cycle therapy aromatase inhibitors and SERM recovery tablets.']
                ]
            ],
            [
                'name' => 'Injectables 1 ml',
                'description' => 'Single-dose 1 ml glass ampoules formulated for optimal bioavailability and maximum stability.',
                'order' => 2,
                'image' => 'img/injectables-icon.png',
                'children' => [
                    ['name' => 'Short Ester Injectables', 'desc' => 'Fast-acting short ester 1ml ampoules for immediate physiological response.'],
                    ['name' => 'Long Ester Injectables', 'desc' => 'Sustained-release long ester 1ml ampoules for extended therapeutic half-life.'],
                    ['name' => 'Blend Injectables', 'desc' => 'Synergized multi-ester 1ml ampoules for continuous hormonal saturation.']
                ]
            ],
            [
                'name' => 'HGH',
                'description' => 'Recombinant Human Growth Hormone (rDNA origin) with 99.8% purity for tissue repair and growth.',
                'order' => 3,
                'image' => 'img/hgh-icon.png',
                'children' => [
                    ['name' => 'Somatropin Vials', 'desc' => 'Freeze-dried 191 aa sequence Somatropin vials with sterile WFI diluent.'],
                    ['name' => 'Cartridge Pens', 'desc' => 'Multi-dose prefilled HGH cartridges and auto-injector dosing pens.'],
                    ['name' => 'Growth Recombinant Solutions', 'desc' => 'High purity recombinant growth hormone liquid formulations and IGF factors.']
                ]
            ],
            [
                'name' => 'Peptides',
                'description' => 'Synthetic peptide hormones synthesized via automated solid-phase peptide synthesis (SPPS).',
                'order' => 4,
                'image' => 'img/peptides-icon.png',
                'children' => [
                    ['name' => 'Recovery Peptides', 'desc' => 'Regenerative repair peptides promoting collagen synthesis and tissue healing.'],
                    ['name' => 'GH Secretagogues', 'desc' => 'GHRH and GHRP secretagogues stimulating endogenous pituitary pulses.'],
                    ['name' => 'Specialty Peptides', 'desc' => 'Specialized therapeutic peptides for metabolic regulation and cellular signaling.']
                ]
            ],
            [
                'name' => 'Injectables 10 ml',
                'description' => 'Multi-dose 10 ml vials sterile filtered with USP grade pharmaceutical carrier oils.',
                'order' => 5,
                'image' => 'img/injectables-10-icon.png',
                'children' => [
                    ['name' => 'Depot Vials 10ml', 'desc' => 'Multi-dose 10ml depot vials sealed with flip-off aluminum caps.'],
                    ['name' => 'High Concentration Vials', 'desc' => 'High potency 10ml vials formulated for reduced injection frequency.'],
                    ['name' => 'Multi-Ester Blend 10ml', 'desc' => 'Synergistic 10ml multi-ester compounds for rapid and sustained output.']
                ]
            ],
        ];

        $subCategoryModels = [];

        foreach ($categoriesData as $cat) {
            $parent = Category::create([
                'parent_id' => null,
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'image_path' => $cat['image'],
                'order' => $cat['order'],
                'meta_title' => 'Zerox Pharmaceuticals - ' . $cat['name'],
                'meta_description' => $cat['description'],
            ]);

            foreach ($cat['children'] as $index => $childData) {
                $sub = Category::create([
                    'parent_id' => $parent->id,
                    'name' => $childData['name'],
                    'slug' => Str::slug($childData['name']),
                    'description' => $childData['desc'],
                    'image_path' => $cat['image'],
                    'order' => $index + 1,
                    'meta_title' => 'Zerox - ' . $childData['name'],
                    'meta_description' => $childData['desc'],
                ]);

                $subCategoryModels[$childData['name']] = $sub;
            }
        }

        // 3. Products Master Definition: 15 Products per Subcategory (13 Subcategories * 15 = 195 Products Total!)
        $productsBySubCat = [
            'Anabolic Tablets' => [
                ['name' => 'Anavar 10mg', 'dosage' => '10mg/tab', 'pack' => '100 Tablets', 'desc' => 'Oxandrolone oral tablets for lean tissue retention and cellular synthesis.'],
                ['name' => 'Anavar 20mg', 'dosage' => '20mg/tab', 'pack' => '100 Tablets', 'desc' => 'High concentration Oxandrolone oral tablets for maximum strength.'],
                ['name' => 'Dianabol 10mg', 'dosage' => '10mg/tab', 'pack' => '100 Tablets', 'desc' => 'Methandrostenolone tablets for intense nitrogen retention and mass gain.'],
                ['name' => 'Dianabol 20mg', 'dosage' => '20mg/tab', 'pack' => '100 Tablets', 'desc' => 'High potency Methandrostenolone tablets for rapid muscle volume.'],
                ['name' => 'Winstrol 10mg', 'dosage' => '10mg/tab', 'pack' => '100 Tablets', 'desc' => 'Stanozolol oral tablets formulated for muscle hardness and vascularity.'],
                ['name' => 'Winstrol 50mg', 'dosage' => '50mg/tab', 'pack' => '50 Tablets', 'desc' => 'Concentrated Stanozolol tablets for maximum physical conditioning.'],
                ['name' => 'Anadrol 50mg', 'dosage' => '50mg/tab', 'pack' => '50 Tablets', 'desc' => 'Oxymetholone tablets for rapid red blood cell production and power.'],
                ['name' => 'Turinabol 10mg', 'dosage' => '10mg/tab', 'pack' => '100 Tablets', 'desc' => '4-Chlorodehydromethyltestosterone for quality strength without water retention.'],
                ['name' => 'Turinabol 25mg', 'dosage' => '25mg/tab', 'pack' => '50 Tablets', 'desc' => 'High purity Oral Turinabol for clean athletic performance.'],
                ['name' => 'Proviron 25mg', 'dosage' => '25mg/tab', 'pack' => '50 Tablets', 'desc' => 'Mesterolone tablets acting as an androgenic enhancer and aromatase inhibitor.'],
                ['name' => 'Halotestin 10mg', 'dosage' => '10mg/tab', 'pack' => '50 Tablets', 'desc' => 'Fluoxymesterone potent androgenic oral tablet for maximum strength response.'],
                ['name' => 'Primobolan Oral 25mg', 'dosage' => '25mg/tab', 'pack' => '50 Tablets', 'desc' => 'Methenolone Acetate oral tablets for mild, high-quality tissue preservation.'],
                ['name' => 'Methyltestosterone 25mg', 'dosage' => '25mg/tab', 'pack' => '100 Tablets', 'desc' => 'Fast acting oral testosterone compound for aggression and strength.'],
                ['name' => 'Epistane 10mg', 'dosage' => '10mg/tab', 'pack' => '90 Tablets', 'desc' => 'Anti-estrogenic dry anabolic oral compound for muscle density.'],
                ['name' => 'Superdrol 10mg', 'dosage' => '10mg/tab', 'pack' => '90 Tablets', 'desc' => 'Methasterone oral tablet engineered for rapid muscle fullness.']
            ],
            'Metabolic & Fat Burners' => [
                ['name' => 'Clenbuterol 40mcg', 'dosage' => '40mcg/tab', 'pack' => '100 Tablets', 'desc' => 'Clenbuterol Hydrochloride bronchodilator for thermogenic metabolic elevation.'],
                ['name' => 'Clenbuterol 60mcg', 'dosage' => '60mcg/tab', 'pack' => '100 Tablets', 'desc' => 'High potency Clenbuterol for enhanced beta-2 adrenergic stimulation.'],
                ['name' => 'Cytomel T3 25mcg', 'dosage' => '25mcg/tab', 'pack' => '100 Tablets', 'desc' => 'Liothyronine Sodium synthetic thyroid hormone for metabolic rate control.'],
                ['name' => 'Cytomel T3 50mcg', 'dosage' => '50mcg/tab', 'pack' => '100 Tablets', 'desc' => 'Concentrated Liothyronine T3 for rapid lipid oxidation.'],
                ['name' => 'Thybon T4 100mcg', 'dosage' => '100mcg/tab', 'pack' => '100 Tablets', 'desc' => 'Levothyroxine Sodium T4 thyroid pro-hormone tablet.'],
                ['name' => 'Albuterol 4mg', 'dosage' => '4mg/tab', 'pack' => '100 Tablets', 'desc' => 'Short-acting beta-2 agonist for clean fat loss and stamina.'],
                ['name' => 'Yohimbine HCL 5mg', 'dosage' => '5mg/tab', 'pack' => '100 Tablets', 'desc' => 'Alpha-2 receptor antagonist for targeted lipolysis.'],
                ['name' => 'Sibutramine 15mg', 'dosage' => '15mg/tab', 'pack' => '50 Tablets', 'desc' => 'Centrally acting appetite suppressant for controlled caloric intake.'],
                ['name' => 'Salbutamol 2mg', 'dosage' => '2mg/tab', 'pack' => '100 Tablets', 'desc' => 'Therapeutic beta-agonist for bronchial dilatation and metabolic speed.'],
                ['name' => 'Triac 350mcg', 'dosage' => '350mcg/tab', 'pack' => '100 Tablets', 'desc' => 'Tiratricol thyroid analogue promoting fat breakdown.'],
                ['name' => 'Caffeine Anhydrous 200mg', 'dosage' => '200mg/tab', 'pack' => '100 Tablets', 'desc' => 'Pharmaceutical grade USP caffeine for mental focus and energy.'],
                ['name' => 'Ephedrine HCL 30mg', 'dosage' => '30mg/tab', 'pack' => '50 Tablets', 'desc' => 'Sympathomimetic amine for thermogenesis and appetite control.'],
                ['name' => 'Synephrine 20mg', 'dosage' => '20mg/tab', 'pack' => '100 Tablets', 'desc' => 'Citrus aurantium extract for clean adrenergic stimulation.'],
                ['name' => 'Cardarine GW501516 10mg', 'dosage' => '10mg/tab', 'pack' => '60 Tablets', 'desc' => 'PPAR-delta receptor agonist for cardiovascular endurance and lipolysis.'],
                ['name' => 'Stenabolic SR9009 10mg', 'dosage' => '10mg/tab', 'pack' => '60 Tablets', 'desc' => 'Rev-ErbA agonist regulating circadian rhythm and lipid metabolism.']
            ],
            'PCT & Recovery Tablets' => [
                ['name' => 'Tamoxifen Nolvadex 20mg', 'dosage' => '20mg/tab', 'pack' => '100 Tablets', 'desc' => 'Selective Estrogen Receptor Modulator (SERM) for post-cycle estrogen blockade.'],
                ['name' => 'Clomiphene Clomid 50mg', 'dosage' => '50mg/tab', 'pack' => '50 Tablets', 'desc' => 'SERM stimulating pituitary gonadotropin release (LH & FSH).'],
                ['name' => 'Arimidex Anastrozole 1mg', 'dosage' => '1mg/tab', 'pack' => '50 Tablets', 'desc' => 'Non-steroidal aromatase inhibitor suppressing serum estrogen level.'],
                ['name' => 'Femara Letrozole 2.5mg', 'dosage' => '2.5mg/tab', 'pack' => '30 Tablets', 'desc' => 'Potent third-generation aromatase inhibitor for gynecomastia prevention.'],
                ['name' => 'Aromasin Exemestane 25mg', 'dosage' => '25mg/tab', 'pack' => '30 Tablets', 'desc' => 'Irreversible suicidal aromatase inactivator preventing estrogen rebound.'],
                ['name' => 'Cabergoline Dostinex 0.5mg', 'dosage' => '0.5mg/tab', 'pack' => '20 Tablets', 'desc' => 'Dopamine receptor agonist suppressing pituitary prolactin secretion.'],
                ['name' => 'Raloxifene 60mg', 'dosage' => '60mg/tab', 'pack' => '50 Tablets', 'desc' => 'Targeted SERM with strong affinity for breast tissue estrogen receptors.'],
                ['name' => 'Toremifene Citrate 30mg', 'dosage' => '30mg/tab', 'pack' => '50 Tablets', 'desc' => 'Next generation SERM for HPTA axis restoration.'],
                ['name' => 'Proviron PCT 50mg', 'dosage' => '50mg/tab', 'pack' => '50 Tablets', 'desc' => 'Mesterolone tablet supporting free testosterone unbinding.'],
                ['name' => 'Tamoxifen Nolvadex 10mg', 'dosage' => '10mg/tab', 'pack' => '100 Tablets', 'desc' => 'Maintenance dose Tamoxifen Citrate SERM.'],
                ['name' => 'Clomiphene Clomid 25mg', 'dosage' => '25mg/tab', 'pack' => '50 Tablets', 'desc' => 'Low dose Clomiphene for gradual gonadotropin recovery.'],
                ['name' => 'Anastrozole 0.5mg', 'dosage' => '0.5mg/tab', 'pack' => '50 Tablets', 'desc' => 'Micro-dose Arimidex for precise estrogen control.'],
                ['name' => 'Exemestane 12.5mg', 'dosage' => '12.5mg/tab', 'pack' => '30 Tablets', 'desc' => 'Half-strength Aromasin for controlled aromatase suppression.'],
                ['name' => 'TUDCA Liver Guard 250mg', 'dosage' => '250mg/tab', 'pack' => '60 Tablets', 'desc' => 'Tauroursodeoxycholic acid for hepatoprotection and bile flow.'],
                ['name' => 'NAC Glutathione Shield 600mg', 'dosage' => '600mg/tab', 'pack' => '60 Tablets', 'desc' => 'N-Acetyl Cysteine cellular antioxidant and liver detoxifier.']
            ],
            'Short Ester Injectables' => [
                ['name' => 'Testorox Prop 100mg/ml', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Testosterone Propionate fast-acting injectable solution in USP sesame oil.'],
                ['name' => 'Testorox Prop 150mg/ml', 'dosage' => '150mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'High concentration Testosterone Propionate ampoules.'],
                ['name' => 'Trenrox A 100mg/ml', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Trenbolone Acetate fast-acting short ester injectable for rapid conditioning.'],
                ['name' => 'Masterox P 100mg/ml', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Drostanolone Propionate ampoules engineered for anti-estrogenic conditioning.'],
                ['name' => 'Masterox P 150mg/ml', 'dosage' => '150mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Concentrated Drostanolone Propionate 1ml ampoules.'],
                ['name' => 'Nandrorox F (NPP) 100mg/ml', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Nandrolone Phenylpropionate short-acting ester for controlled recovery.'],
                ['name' => 'Winstrol Depot 50mg/ml', 'dosage' => '50mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Stanozolol aqueous suspension for muscle hardness.'],
                ['name' => 'Testosterone Base 100mg/ml', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Unesterified pure Testosterone suspension in water.'],
                ['name' => 'Boldenone Acetate 100mg/ml', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Short ester Equipoise for rapid tissue stimulation.'],
                ['name' => 'Primobolan Acetate 100mg/ml', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Short ester Methenolone injectable ampoules.'],
                ['name' => 'Trenbolone Acetate 75mg/ml', 'dosage' => '75mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Standard therapeutic Trenbolone Acetate formulation.'],
                ['name' => 'Test-P & Masteron Cut-Blend', 'dosage' => '150mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Testosterone Propionate 75mg + Masteron Propionate 75mg.'],
                ['name' => 'Short Ester Tri-Blend 150mg', 'dosage' => '150mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Test Prop 50mg + Tren Acetate 50mg + Masteron Prop 50mg.'],
                ['name' => 'Methandrienone Injectable 50mg/ml', 'dosage' => '50mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Water-based Dianabol injectable suspension.'],
                ['name' => 'Stanozolol Oil Based 50mg/ml', 'dosage' => '50mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Micro-refined oil-based Winstrol injectable.']
            ],
            'Long Ester Injectables' => [
                ['name' => 'Testorox E 250mg/ml', 'dosage' => '250mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Testosterone Enanthate sterile injectable solution for sustained serum concentration.'],
                ['name' => 'Testorox E 300mg/ml', 'dosage' => '300mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'High concentration Testosterone Enanthate ampoules.'],
                ['name' => 'Testorox Cypionate 250mg/ml', 'dosage' => '250mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Testosterone Cypionate long ester 1ml glass ampoules.'],
                ['name' => 'Testorox Cypionate 300mg/ml', 'dosage' => '300mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Concentrated Testosterone Cypionate solution.'],
                ['name' => 'Decarox 250mg/ml', 'dosage' => '250mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Nandrolone Decanoate ampoules supporting collagen synthesis.'],
                ['name' => 'Decarox 300mg/ml', 'dosage' => '300mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'High potency Nandrolone Decanoate ampoules.'],
                ['name' => 'Boldrox 200mg/ml', 'dosage' => '200mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Boldenone Undecylenate ampoules supporting steady appetite.'],
                ['name' => 'Boldenone Undecylenate 300mg/ml', 'dosage' => '300mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Concentrated Equipoise 300mg/ml 1ml solution.'],
                ['name' => 'Primorox 100mg/ml', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Methenolone Enanthate injectable for non-aromatizing development.'],
                ['name' => 'Methenolone Enanthate 200mg/ml', 'dosage' => '200mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Double strength Primobolan Depot ampoules.'],
                ['name' => 'Trenrox E 200mg/ml', 'dosage' => '200mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Trenbolone Enanthate long ester formulation.'],
                ['name' => 'Trenbolone Enanthate 250mg/ml', 'dosage' => '250mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Concentrated Trenbolone Enanthate ampoules.'],
                ['name' => 'Masterox E 200mg/ml', 'dosage' => '200mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Drostanolone Enanthate long ester 1ml ampoules.'],
                ['name' => 'Nandrolone Cypionate 200mg/ml', 'dosage' => '200mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Long ester Nandrolone formulation in USP sesame carrier.'],
                ['name' => 'Parabolan Hexa 100mg/ml', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Trenbolone Hexahydrobenzylcarbonate 1ml glass ampoules.']
            ],
            'Blend Injectables' => [
                ['name' => 'Testorox Mix (Sustanon) 250mg/ml', 'dosage' => '250mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Four-ester Testosterone blend delivering immediate and sustained hormonal output.'],
                ['name' => 'Sustanon 350mg/ml', 'dosage' => '350mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'High concentration four-ester Testosterone blend.'],
                ['name' => 'Rip Blend 225mg/ml', 'dosage' => '225mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Test Prop 75mg + Tren Acetate 75mg + Masteron Prop 75mg.'],
                ['name' => 'Mass Stack Blend 400mg/ml', 'dosage' => '400mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Test Enanthate 200mg + Deca 100mg + Boldenone 100mg.'],
                ['name' => 'Cut Blend 150mg/ml', 'dosage' => '150mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Test Prop 50mg + Winstrol 50mg + Masteron 50mg.'],
                ['name' => 'Tri-Test Blend 400mg/ml', 'dosage' => '400mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Test Enanthate 150mg + Test Cypionate 150mg + Test Prop 100mg.'],
                ['name' => 'Supertest 450mg/ml', 'dosage' => '450mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Five-ester Testosterone high concentration blend.'],
                ['name' => 'Tren/Test/Masteron Blend 300mg/ml', 'dosage' => '300mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Long ester cutting and hardening triple blend.'],
                ['name' => 'Anabolic Mass Blend 500mg/ml', 'dosage' => '500mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Heavyweight bulk compound for advanced applications.'],
                ['name' => 'Power Stack Blend 350mg/ml', 'dosage' => '350mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Testosterone Enanthate + Nandrolone Decanoate synergized solution.'],
                ['name' => 'Mega Blend 400mg/ml', 'dosage' => '400mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Testosterone + Equipoise high payload formulation.'],
                ['name' => 'Ultra-Mass 500mg/ml', 'dosage' => '500mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Maximum solubility multi-ester depot injectable.'],
                ['name' => 'Pro-Cut Blend 200mg/ml', 'dosage' => '200mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Short ester vascular density compound.'],
                ['name' => 'Lean Mass Blend 300mg/ml', 'dosage' => '300mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Testosterone Enanthate + Drostanolone Enanthate dual blend.'],
                ['name' => 'Fast Acting Blend 150mg/ml', 'dosage' => '150mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Test Propionate + Trenbolone Acetate quick action blend.']
            ],
            'Somatropin Vials' => [
                ['name' => 'Somatropin 10IU', 'dosage' => '10IU/vial', 'pack' => '10 Vials + Diluent', 'desc' => 'Human Growth Hormone rDNA 191 amino acid sequence identical to endogenous GH.'],
                ['name' => 'Zerotropin 12IU', 'dosage' => '12IU/vial', 'pack' => '10 Vials + Bacteriostatic Water', 'desc' => 'High purity Somatropin engineered for cellular regeneration.'],
                ['name' => 'Humatrope 18IU', 'dosage' => '18IU/vial', 'pack' => '1 Kit (18IU)', 'desc' => 'Lyophilized Human Growth Hormone for clinical growth support.'],
                ['name' => 'Omnitrope 10IU', 'dosage' => '10IU/vial', 'pack' => '10 Vials', 'desc' => 'Highly refined Somatropin powder for lipolysis.'],
                ['name' => 'Saizen 20IU', 'dosage' => '20IU/vial', 'pack' => '5 Vials + Solvent', 'desc' => 'Concentrated Somatropin formulation for rapid tissue restoration.'],
                ['name' => 'Hygetropin 8IU', 'dosage' => '8IU/vial', 'pack' => '25 Vials Box', 'desc' => 'Pharmaceutical grade recombinant human growth hormone.'],
                ['name' => 'Jintropin 10IU', 'dosage' => '10IU/vial', 'pack' => '10 Vials', 'desc' => 'Secretion technology human growth hormone ensuring zero residue.'],
                ['name' => 'Ansomone 10IU', 'dosage' => '10IU/vial', 'pack' => '10 Vials + WFI', 'desc' => 'Freeze-dried 191 aa sequence rHGH for protein synthesis.'],
                ['name' => 'Norditropin 10IU Vial', 'dosage' => '10IU/vial', 'pack' => '10 Vials', 'desc' => 'Lyophilized Somatropin powder for reconstitution.'],
                ['name' => 'Kigtropin 10IU', 'dosage' => '10IU/vial', 'pack' => '10 Vials', 'desc' => 'High purity freeze-dried growth hormone.'],
                ['name' => 'Riptropin 12IU', 'dosage' => '12IU/vial', 'pack' => '10 Vials', 'desc' => 'Enhanced stability recombinant somatropin.'],
                ['name' => 'Getropin 10IU', 'dosage' => '10IU/vial', 'pack' => '10 Vials', 'desc' => 'Standard recombinant human growth hormone.'],
                ['name' => 'Taitropin 10IU', 'dosage' => '10IU/vial', 'pack' => '10 Vials', 'desc' => 'USP grade 191 amino acid HGH.'],
                ['name' => 'Eurotropin 12IU', 'dosage' => '12IU/vial', 'pack' => '10 Vials', 'desc' => 'European Pharmacopoeia standard Somatropin.'],
                ['name' => 'Glotropin 10IU', 'dosage' => '10IU/vial', 'pack' => '10 Vials', 'desc' => 'Lyophilized somatropin powder for subcutaneous injection.']
            ],
            'Cartridge Pens' => [
                ['name' => 'Norditropin 15IU Pen', 'dosage' => '15IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'Premixed Somatropin liquid formulation for precise micro-dosing.'],
                ['name' => 'Genotropin 16IU Cartridge', 'dosage' => '16IU/cartridge', 'pack' => '5 Cartridges', 'desc' => 'Two-chamber lyophilized HGH cartridge for effortless mixing.'],
                ['name' => 'HumatroPen 36IU', 'dosage' => '36IU/pen', 'pack' => '1 Pen Device', 'desc' => 'Reusable precision multi-dose injection pen device.'],
                ['name' => 'Omnitrope Pen 5mg (15IU)', 'dosage' => '15IU/pen', 'pack' => '1 Cartridge Pen', 'desc' => 'Premixed liquid Somatropin cartridge for quick injection.'],
                ['name' => 'Saizen EasyPod 8mg (24IU)', 'dosage' => '24IU/cartridge', 'pack' => '5 Cartridges', 'desc' => 'Automated electronic dosage cartridge system.'],
                ['name' => 'Nordiflex 10mg Pen', 'dosage' => '30IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'High dose liquid Somatropin prefilled pen.'],
                ['name' => 'Genotropin GoQuick 12mg (36IU)', 'dosage' => '36IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'Two-chamber prefilled HGH mixing pen.'],
                ['name' => 'Nutropin NuSpin 10mg', 'dosage' => '30IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'Dial-a-dose liquid somatropin injector pen.'],
                ['name' => 'Zerotropin Prefilled Pen 15IU', 'dosage' => '15IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'Sterile liquid Somatropin in disposable pen.'],
                ['name' => 'Somatropin AutoPen 30IU', 'dosage' => '30IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'Automatic spring-loaded HGH injector pen.'],
                ['name' => 'SmartStart HGH Pen 12IU', 'dosage' => '12IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'Compact dosage somatropin cartridge pen.'],
                ['name' => 'AutoPen Somatropin 15IU', 'dosage' => '15IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'Precision click dosing growth hormone pen.'],
                ['name' => 'Biotropin Pen 10IU', 'dosage' => '10IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'Ergonomic Somatropin delivery system.'],
                ['name' => 'Norditropin FlexPro 15mg', 'dosage' => '45IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'Maximum dose FlexPro liquid HGH pen.'],
                ['name' => 'Cartridge Liquid HGH 20IU', 'dosage' => '20IU/cartridge', 'pack' => '5 Cartridges', 'desc' => 'Glass cartridge premixed liquid HGH.']
            ],
            'Growth Recombinant Solutions' => [
                ['name' => 'Recombinant GH Liquid 10ml', 'dosage' => '100IU/vial', 'pack' => '10ml Vial', 'desc' => 'Premixed liquid Somatropin solution in 10ml vial.'],
                ['name' => 'Somatropin Serum 100IU', 'dosage' => '100IU/vial', 'pack' => '10ml Vial', 'desc' => 'High concentration liquid HGH serum.'],
                ['name' => 'IGF-1 LR3 1mg', 'dosage' => '1mg/vial', 'pack' => '5 Vials', 'desc' => 'Insulin-like Growth Factor-1 Long R3 recombinant peptide.'],
                ['name' => 'Mechano Growth Factor MGF 2mg', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'Splice variant of IGF-1 stimulating muscle stem cells.'],
                ['name' => 'Pegylated IGF-1 1mg', 'dosage' => '1mg/vial', 'pack' => '5 Vials', 'desc' => 'PEGylated Long R3 IGF-1 with extended half-life.'],
                ['name' => 'Des-IGF-1 1mg', 'dosage' => '1mg/vial', 'pack' => '5 Vials', 'desc' => 'Truncated IGF-1 analogue with 10x potency.'],
                ['name' => 'HGH Fragment 176-191 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Lipolytic C-terminal fragment of Human Growth Hormone.'],
                ['name' => 'Long R3 IGF-1 1mg', 'dosage' => '1mg/vial', 'pack' => '5 Vials', 'desc' => '83 amino acid analogue of human IGF-1.'],
                ['name' => 'Recombinant Human IGF-1 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Mecasermin rDNA origin human IGF-1.'],
                ['name' => 'GH Secretagogue Liquid 10ml', 'dosage' => '50mg/ml', 'pack' => '10ml Vial', 'desc' => 'Oral secretagogue liquid solution.'],
                ['name' => 'Bio-Regenerative GH Liquid 50IU', 'dosage' => '50IU/vial', 'pack' => '10ml Vial', 'desc' => 'Cellular repair liquid GH complex.'],
                ['name' => 'Tissue Repair Serum 10ml', 'dosage' => '20mg/ml', 'pack' => '10ml Vial', 'desc' => 'Peptide growth factor recovery complex.'],
                ['name' => 'Somatropin Diluent Pack', 'dosage' => '10ml WFI', 'pack' => '10 Vials WFI', 'desc' => 'Bacteriostatic water with 0.9% benzyl alcohol.'],
                ['name' => 'Bacteriostatic Water 10ml', 'dosage' => '10ml/vial', 'pack' => '10 Vials', 'desc' => 'Sterile diluent for peptide reconstitution.'],
                ['name' => 'Sterile Water WFI 10ml', 'dosage' => '10ml/vial', 'pack' => '10 Vials', 'desc' => 'Water for Injection USP grade sterile solvent.']
            ],
            'Recovery Peptides' => [
                ['name' => 'BPC-157 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Body Protection Compound-157 peptide for tendon, ligament, and gut repair.'],
                ['name' => 'BPC-157 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'Double strength BPC-157 lyophilized powder.'],
                ['name' => 'TB-500 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Thymosin Beta-4 synthetic peptide facilitating cell migration.'],
                ['name' => 'TB-500 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'Concentrated Thymosin Beta-4 peptide.'],
                ['name' => 'Healing Stack BPC+TB 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'BPC-157 5mg + TB-500 5mg combined recovery vial.'],
                ['name' => 'KPV Peptide 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Anti-inflammatory tri-peptide for tissue repair.'],
                ['name' => 'GHK-Cu Copper Peptide 50mg', 'dosage' => '50mg/vial', 'pack' => '5 Vials', 'desc' => 'Glycyl-L-histidyl-L-lysine copper complex for skin & collagen.'],
                ['name' => 'Epithalon 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'Synthetic tetrapeptide telomerase activator.'],
                ['name' => 'Thymosin Alpha-1 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'Immune modulating polypeptide.'],
                ['name' => 'LL-37 Peptide 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Antimicrobial host-defense peptide.'],
                ['name' => 'MOTS-c 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'Mitochondrial derived peptide regulating metabolic homeostasis.'],
                ['name' => 'Humanin 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'Cytoprotective mitochondrial micro-peptide.'],
                ['name' => 'ARA-290 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'Erythropoietin receptor agonist peptide for nerve repair.'],
                ['name' => 'Selank 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'Regulatory heptapeptide for neuroprotection.'],
                ['name' => 'Semax 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'ACTH analogue peptide for cognitive performance.']
            ],
            'GH Secretagogues' => [
                ['name' => 'CJC-1295 DAC 2mg', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'GHRH analogue with Drug Affinity Complex extending half-life.'],
                ['name' => 'CJC-1295 No DAC 2mg', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'Modified GRF 1-29 for pulsatile GH stimulation.'],
                ['name' => 'Ipamorelin 2mg', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'Selective Ghrelin secretagogue without cortisol elevation.'],
                ['name' => 'Ipamorelin 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Concentrated Ipamorelin peptide powder.'],
                ['name' => 'GHRP-6 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Growth Hormone Releasing Peptide-6 stimulating GH pulse.'],
                ['name' => 'GHRP-2 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Second generation GHRP for potent somatotrop response.'],
                ['name' => 'Sermorelin 2mg', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'GHRH 1-29 peptide fragment stimulating natural GH.'],
                ['name' => 'Sermorelin 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'High dose Sermorelin Acetate peptide.'],
                ['name' => 'Hexarelin 2mg', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'Hexapeptide growth secretagogue with cardioprotective action.'],
                ['name' => 'Tesamorelin 2mg', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'Stabilized GHRH analogue for lipodystrophy control.'],
                ['name' => 'Tesamorelin 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Concentrated Tesamorelin peptide.'],
                ['name' => 'MK-677 Ibutamoren 25mg', 'dosage' => '25mg/tab', 'pack' => '60 Tablets', 'desc' => 'Oral non-peptide ghrelin receptor agonist.'],
                ['name' => 'Macimorelin 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'Orally active GH secretagogue.'],
                ['name' => 'Alarelix 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'GnRH agonist peptide analogue.'],
                ['name' => 'Triptorelin 1mg', 'dosage' => '1mg/vial', 'pack' => '1 Vial', 'desc' => 'GnRH agonist for pituitary reboot.']
            ],
            'Specialty Peptides' => [
                ['name' => 'Melanotan II 10mg', 'dosage' => '10mg/vial', 'pack' => '1 Vial', 'desc' => 'Synthetic alpha-MSH analogue for skin melanogenesis.'],
                ['name' => 'PT-141 Bremelanotide 10mg', 'dosage' => '10mg/vial', 'pack' => '1 Vial', 'desc' => 'Central melanocortin receptor agonist.'],
                ['name' => 'AOD-9604 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Lipolytic C-terminal fragment 177-191 of human GH.'],
                ['name' => 'Fragment 176-191 2mg', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'Standard HGH fat loss fragment peptide.'],
                ['name' => 'Thymalin 10mg', 'dosage' => '10mg/vial', 'pack' => '5 Vials', 'desc' => 'Bioregulatory peptide for immune restoration.'],
                ['name' => 'Oxytocin 10IU', 'dosage' => '10IU/vial', 'pack' => '5 Vials', 'desc' => 'Neuropeptide hormone regulating social bonding.'],
                ['name' => 'DSIP Sleep Peptide 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Delta Sleep-Inducing Peptide for REM sleep architecture.'],
                ['name' => 'Kisspeptin-10 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Endogenous peptide initiating GnRH release.'],
                ['name' => 'Follistatin-344 1mg', 'dosage' => '1mg/vial', 'pack' => '1 Vial', 'desc' => 'Myostatin inhibitor autocrine glycoprotein.'],
                ['name' => 'ACE-031 1mg', 'dosage' => '1mg/vial', 'pack' => '1 Vial', 'desc' => 'Soluble ActRIIB receptor fusion protein.'],
                ['name' => 'Gonadorelin 2mg', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'Endogenous GnRH peptide for testicular function.'],
                ['name' => 'Triptorelin 0.1mg', 'dosage' => '0.1mg/vial', 'pack' => '5 Vials', 'desc' => 'Low dose GnRH agonist.'],
                ['name' => 'Cortagen 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Brain bioregulatory tetrapeptide.'],
                ['name' => 'Pinealon 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'CNS protective peptide complex.'],
                ['name' => 'Vesugen 5mg', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Vascular wall regulatory peptide.']
            ],
            'Depot Vials 10ml' => [
                ['name' => 'Testorox Enanthate 10ml', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Testosterone Enanthate multi-dose vial formulated in USP grade castor oil base.'],
                ['name' => 'Testorox Cypionate 10ml', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Testosterone Cypionate long ester 10ml vial providing stable serum levels.'],
                ['name' => 'Decarox 250 10ml', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Nandrolone Decanoate high concentration 10ml multi-dose sterile solution.'],
                ['name' => 'Boldenone Undecylenate 10ml', 'dosage' => '300mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Equipoise 300mg/ml injectable solution engineered for smooth vascular density.'],
                ['name' => 'Trenrox Hexa 10ml', 'dosage' => '100mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Trenbolone Hexahydrobenzylcarbonate (Parabolan ester) 10ml vial formulation.'],
                ['name' => 'Sustarox 250 10ml', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Multi-ester Testosterone blend in a 10ml multidose vial with benzyl alcohol.'],
                ['name' => 'Masterox E 200 10ml', 'dosage' => '200mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Drostanolone Enanthate 200mg/ml long ester vial for prolonged anti-estrogenic conditioning.'],
                ['name' => 'Primobolan Depot 100 10ml', 'dosage' => '100mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Methenolone Enanthate 100mg/ml 10ml vial offering smooth intramuscular absorption.'],
                ['name' => 'Testosterone Enanthate 300 10ml', 'dosage' => '300mg/ml', 'pack' => '10 ml Vial', 'desc' => 'High strength Testosterone Enanthate multi-dose depot vial.'],
                ['name' => 'Deca-Durabolin 300 10ml', 'dosage' => '300mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Concentrated Nandrolone Decanoate 300mg/ml 10ml vial.'],
                ['name' => 'Boldenone 400 10ml', 'dosage' => '400mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Ultra concentrated Equipoise 400mg/ml 10ml vial.'],
                ['name' => 'Trenbolone Enanthate 200 10ml', 'dosage' => '200mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Trenbolone Enanthate long ester 10ml multi-dose vial.'],
                ['name' => 'Masteron Enanthate 250 10ml', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Drostanolone Enanthate 250mg/ml 10ml vial.'],
                ['name' => 'Primobolan 200 10ml', 'dosage' => '200mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Double strength Methenolone Enanthate 10ml vial.'],
                ['name' => 'Test Cypionate 300 10ml', 'dosage' => '300mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Testosterone Cypionate 300mg/ml multi-dose vial.']
            ],
            'High Concentration Vials' => [
                ['name' => 'Testorox 400 10ml', 'dosage' => '400mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Super concentrated Testosterone Enanthate 400mg/ml 10ml vial.'],
                ['name' => 'Mass-Stack 500 10ml', 'dosage' => '500mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Test Enanthate 250mg + Deca 150mg + Boldenone 100mg.'],
                ['name' => 'Mega-Blend 450 10ml', 'dosage' => '450mg/ml', 'pack' => '10 ml Vial', 'desc' => 'High payload multi-ester anabolic compound.'],
                ['name' => 'Sustan 400 10ml', 'dosage' => '400mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Concentrated four-ester Testosterone 400mg/ml 10ml vial.'],
                ['name' => 'Deca-Max 400 10ml', 'dosage' => '400mg/ml', 'pack' => '10 ml Vial', 'desc' => 'High payload Nandrolone Decanoate 400mg/ml 10ml vial.'],
                ['name' => 'Bold-Max 450 10ml', 'dosage' => '450mg/ml', 'pack' => '10 ml Vial', 'desc' => 'High density Boldenone Undecylenate 450mg/ml 10ml vial.'],
                ['name' => 'Tren-Max 250 10ml', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'High concentration Trenbolone Enanthate 250mg/ml 10ml vial.'],
                ['name' => 'Supertest 500 10ml', 'dosage' => '500mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Five-ester Testosterone 500mg/ml ultra depot vial.'],
                ['name' => 'Ultra-Mass 500 10ml', 'dosage' => '500mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Synergized bulk builder 500mg/ml 10ml vial.'],
                ['name' => 'Power-Stack 450 10ml', 'dosage' => '450mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Testosterone + Deca heavy duty formulation.'],
                ['name' => 'Tri-Test 400 10ml', 'dosage' => '400mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Enanthate + Cypionate + Propionate 400mg/ml 10ml vial.'],
                ['name' => 'Monster-Mass 600 10ml', 'dosage' => '600mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Extreme payload anabolic compound.'],
                ['name' => 'Heavy-Duty Stack 500 10ml', 'dosage' => '500mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Testosterone + Boldenone high concentration vial.'],
                ['name' => 'Extreme-Cut 300 10ml', 'dosage' => '300mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Trenbolone + Drostanolone high density short ester blend.'],
                ['name' => 'Anabolic Pro-Stack 500 10ml', 'dosage' => '500mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Professional Grade high payload 10ml multi-dose vial.']
            ],
            'Multi-Ester Blend 10ml' => [
                ['name' => 'Trenbolone Tri-Blend 10ml', 'dosage' => '150mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Acetate, Enanthate, and Hexa Trenbolone tri-ester blend.'],
                ['name' => 'Test-Blend 4 Esters 10ml', 'dosage' => '300mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Propionate, Phenylpropionate, Isocaproate, Caproate blend.'],
                ['name' => 'Cut-Stack 3-in-1 10ml', 'dosage' => '225mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Test Prop 75mg + Tren Acetate 75mg + Masteron Prop 75mg.'],
                ['name' => 'Mass-Stack Injection 10ml', 'dosage' => '400mg/ml', 'pack' => '10 ml Vial', 'desc' => 'High-potency synergized compound containing Testosterone, Deca, and Boldenone.'],
                ['name' => 'Lean-Cut 200 10ml', 'dosage' => '200mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Test Propionate 100mg + Masteron Propionate 100mg.'],
                ['name' => 'Tri-Ester Testosterone 350 10ml', 'dosage' => '350mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Enanthate 150mg + Cypionate 150mg + Propionate 50mg.'],
                ['name' => 'Masteron/Prop Blend 200 10ml', 'dosage' => '200mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Short ester cutting synergy 10ml vial.'],
                ['name' => 'Tren/Test/Deca Blend 400 10ml', 'dosage' => '400mg/ml', 'pack' => '10 ml Vial', 'desc' => 'All-in-one size & density compound.'],
                ['name' => 'Fast-Slow Test Blend 300 10ml', 'dosage' => '300mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Immediate release + sustained release dual ester.'],
                ['name' => 'Quad-Ester Testosterone 400 10ml', 'dosage' => '400mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Four stage release curve testosterone blend.'],
                ['name' => 'Rip-Stack 250 10ml', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Hardening triple action compound.'],
                ['name' => 'Power-Blend 350 10ml', 'dosage' => '350mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Sustanon + Deca dual multi-ester solution.'],
                ['name' => 'Pro-Synergy 400 10ml', 'dosage' => '400mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Synergistic long ester compound.'],
                ['name' => 'Triple-Action Anabolic 300 10ml', 'dosage' => '300mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Testosterone + Trenbolone + Drostanolone blend.'],
                ['name' => 'Ultimate Mass 450 10ml', 'dosage' => '450mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Maximum muscle volume multi-ester 10ml vial.']
            ]
        ];

        $allCreatedProducts = [];
        $skusCounter = 100;

        foreach ($productsBySubCat as $subName => $products) {
            $subCategory = $subCategoryModels[$subName];

            foreach ($products as $p) {
                $skusCounter++;
                $sku = 'ZX-PRD-' . $skusCounter;

                $product = Product::create([
                    'category_id' => $subCategory->id,
                    'name' => $p['name'],
                    'slug' => Str::slug($p['name']),
                    'sku' => $sku,
                    'dosage_form' => $p['dosage'],
                    'pack_size' => $p['pack'],
                    'description' => $p['desc'],
                    'chemical_characteristics' => "Chemical Name: " . $p['name'] . "\nFormula: C19H28O2 (USP Grade Standard)\nMolar Mass: 288.42 g/mol\nPurity Index: >= 99.4% HPLC Tested\nAppearance: Crystalline Micro-particulate powder / Sterile Clear Carrier Solution\nSolubility: Soluble in ethanol, benzyl benzoate, and sesame oil.",
                    'side_effects' => "Possible mild side effects include androgenic reactions (acne, mild hair thinning in genetically predisposed individuals), lipid profile alterations (temporary elevation of LDL), and transient endogenous hormone suppression. Monitor BP and liver enzymes during extended application periods.",
                    'administration_uses' => "Recommended Protocol: Administer under medical supervision or qualified therapeutic guidelines. Store between 15°C to 25°C protected from direct sunlight. Do not freeze. Verify scratch security code on official authentication portal before first use.",
                    'image_path' => 'img/welcome-image.png',
                    'is_active' => true,
                ]);

                // Create 3 Product Gallery Images per product
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'img/product-verification.png',
                    'order' => 1,
                ]);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'img/welcome-image.png',
                    'order' => 2,
                ]);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'img/logo.png',
                    'order' => 3,
                ]);

                $allCreatedProducts[] = $product;
            }
        }

        // 4. Seed Product Verification Scratch Codes (2 unique codes per product = 390 total codes!)
        $batches = ['ZX-2026-B1', 'ZX-2026-B2', 'ZX-2026-B3', 'ZX-2026-B4', 'ZX-2026-B5', 'ZX-2026-B6', 'ZX-2026-B7', 'ZX-2026-B8'];
        $knownCodes = ['ZX-8829-AB41', 'ZX-9921-DF32', 'ZX-1044-KL89', 'ZX-7734-MN22', 'ZX-3321-OP90'];

        $count = 0;
        foreach ($allCreatedProducts as $product) {
            for ($i = 1; $i <= 2; $i++) {
                $count++;
                if (isset($knownCodes[$count - 1])) {
                    $code = $knownCodes[$count - 1];
                } else {
                    $code = 'ZX-' . rand(1000, 9999) . '-' . strtoupper(Str::random(4));
                }

                $batch = $batches[($count % count($batches))];
                $isVerified = ($count % 6 === 0);

                ProductVerification::create([
                    'product_id' => $product->id,
                    'batch_number' => $batch,
                    'security_code' => $code,
                    'is_verified' => $isVerified,
                    'verified_at' => $isVerified ? now()->subDays(rand(1, 30)) : null,
                    'ip_address' => $isVerified ? '192.168.1.' . rand(10, 250) : null,
                ]);
            }
        }

        // 5. Seed Site Banners (Backend Managed)
        Banner::create([
            'title' => 'Home Banner',
            'subtitle' => 'Working together for a healthier world. Zerox. Life is our life\'s work.',
            'image_path' => 'img/home-banner.png',
            'button_text' => 'See our products',
            'button_url' => '/category/tablets',
            'order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Product Authenticity Protection',
            'subtitle' => 'Verify scratch code directly from master database',
            'image_path' => 'img/authenticity-banner.png',
            'button_text' => 'Verify Code',
            'button_url' => '/authenticity',
            'order' => 2,
            'is_active' => true,
        ]);

        // 6. Seed Site Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Zerox Pharmaceuticals', 'group' => 'general'],
            ['key' => 'company_name', 'value' => 'Zerox Pharmaceuticals Ltd', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+91 11 27023256', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'support@zzerox.com', 'group' => 'contact'],
            ['key' => 'company_address', 'value' => 'Plot No. 42, Industrial Area Phase II, New Delhi, India - 110020', 'group' => 'contact'],
            ['key' => 'map_latitude', 'value' => '28.535516', 'group' => 'contact'],
            ['key' => 'map_longitude', 'value' => '77.261021', 'group' => 'contact'],
            ['key' => 'map_zoom', 'value' => '14', 'group' => 'contact'],
            ['key' => 'hero_title', 'value' => 'Working together for a healthier world. Zerox. Life is our life\'s work.', 'group' => 'banners'],
            ['key' => 'hero_subtitle', 'value' => 'We like to be industry leaders and role models in an ever-changing environment.', 'group' => 'banners'],
            ['key' => 'meta_title', 'value' => 'Zerox – Pharmaceuticals', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Zerox Pharmaceuticals Ltd works for the benefit of citizens of India and around the world, improving the quality of life.', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}
