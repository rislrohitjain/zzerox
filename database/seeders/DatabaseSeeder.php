<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVerification;
use App\Models\SiteSetting;
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

        // 2. Seed Categories (Parents & Subcategories)
        $categoriesData = [
            [
                'name' => 'Tablets',
                'description' => 'Pharmaceutical grade oral tablets produced under strict GMP standards.',
                'order' => 1,
                'children' => ['Anabolic Tablets', 'Metabolic & Fat Burners', 'PCT & Recovery Tablets']
            ],
            [
                'name' => 'Injectables 1 ml',
                'description' => 'Single-dose 1 ml glass ampoules formulated for optimal bioavailability and maximum stability.',
                'order' => 2,
                'children' => ['Short Ester Injectables', 'Long Ester Injectables', 'Blend Injectables']
            ],
            [
                'name' => 'HGH',
                'description' => 'Recombinant Human Growth Hormone (rDNA origin) with 99.8% purity for tissue repair and growth.',
                'order' => 3,
                'children' => ['Somatropin Vials', 'Cartridge Pens']
            ],
            [
                'name' => 'Peptides',
                'description' => 'Synthetic peptide hormones synthesized via automated solid-phase peptide synthesis (SPPS).',
                'order' => 4,
                'children' => ['Recovery Peptides', 'GH Secretagogues', 'Specialty Peptides']
            ],
            [
                'name' => 'Injectables 10 ml',
                'description' => 'Multi-dose 10 ml vials sterile filtered with USP grade pharmaceutical carrier oils.',
                'order' => 5,
                'children' => ['Depot Vials 10ml', 'High Concentration Vials']
            ],
        ];

        $createdCategories = [];

        foreach ($categoriesData as $cat) {
            $parent = Category::create([
                'parent_id' => null,
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'order' => $cat['order'],
                'meta_title' => 'Zerox Pharmaceuticals - ' . $cat['name'],
                'meta_description' => $cat['description'],
            ]);

            $createdCategories[$cat['name']] = $parent;

            foreach ($cat['children'] as $index => $childName) {
                Category::create([
                    'parent_id' => $parent->id,
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'description' => 'Subcategory for ' . $childName,
                    'order' => $index + 1,
                    'meta_title' => 'Zerox - ' . $childName,
                    'meta_description' => 'Explore premium ' . $childName . ' products from Zerox Pharmaceuticals.',
                ]);
            }
        }

        // 3. Products Data Definitions (Exactly 10 per category = 50 total)
        $productsByCat = [
            'Tablets' => [
                ['name' => 'Anavar 10mg', 'sku' => 'ZX-TAB-001', 'dosage' => '10mg/tab', 'pack' => '100 Tablets', 'desc' => 'Oxandrolone oral tablets for lean muscle retention and cellular synthesis.'],
                ['name' => 'Dianabol 10mg', 'sku' => 'ZX-TAB-002', 'dosage' => '10mg/tab', 'pack' => '100 Tablets', 'desc' => 'Methandrostenolone tablets for intense nitrogen retention and mass gain.'],
                ['name' => 'Winstrol 10mg', 'sku' => 'ZX-TAB-003', 'dosage' => '10mg/tab', 'pack' => '100 Tablets', 'desc' => 'Stanozolol oral tablets formulated for muscle hardness and vascularity.'],
                ['name' => 'Anadrol 50mg', 'sku' => 'ZX-TAB-004', 'dosage' => '50mg/tab', 'pack' => '50 Tablets', 'desc' => 'Oxymetholone tablets for rapid red blood cell production and power.'],
                ['name' => 'Turinabol 10mg', 'sku' => 'ZX-TAB-005', 'dosage' => '10mg/tab', 'pack' => '100 Tablets', 'desc' => '4-Chlorodehydromethyltestosterone for quality strength without water retention.'],
                ['name' => 'Clenbuterol 40mcg', 'sku' => 'ZX-TAB-006', 'dosage' => '40mcg/tab', 'pack' => '100 Tablets', 'desc' => 'Clenbuterol Hydrochloride bronchodilator for thermogenic metabolic elevation.'],
                ['name' => 'Proviron 25mg', 'sku' => 'ZX-TAB-007', 'dosage' => '25mg/tab', 'pack' => '50 Tablets', 'desc' => 'Mesterolone tablets acting as an androgenic enhancer and aromatase inhibitor.'],
                ['name' => 'Cytomel T3 25mcg', 'sku' => 'ZX-TAB-008', 'dosage' => '25mcg/tab', 'pack' => '100 Tablets', 'desc' => 'Liothyronine Sodium synthetic thyroid hormone for metabolic rate control.'],
                ['name' => 'Halotestin 10mg', 'sku' => 'ZX-TAB-009', 'dosage' => '10mg/tab', 'pack' => '50 Tablets', 'desc' => 'Fluoxymesterone potent androgenic oral tablet for maximum strength response.'],
                ['name' => 'Primobolan Oral 25mg', 'sku' => 'ZX-TAB-010', 'dosage' => '25mg/tab', 'pack' => '50 Tablets', 'desc' => 'Methenolone Acetate oral tablets for mild, high-quality tissue preservation.'],
            ],
            'Injectables 1 ml' => [
                ['name' => 'Testorox Prop 100mg/ml', 'sku' => 'ZX-AMP-001', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Testosterone Propionate fast-acting injectable solution in USP sesame oil.'],
                ['name' => 'Testorox Mix (Sustanon) 250mg/ml', 'sku' => 'ZX-AMP-002', 'dosage' => '250mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Four-ester Testosterone blend delivering immediate and sustained hormonal output.'],
                ['name' => 'Decarox 100mg/ml', 'sku' => 'ZX-AMP-003', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Nandrolone Decanoate ampoules supporting joint lubrication and collagen synthesis.'],
                ['name' => 'Trenrox A 100mg/ml', 'sku' => 'ZX-AMP-004', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Trenbolone Acetate fast-acting short ester injectable for rapid muscle conditioning.'],
                ['name' => 'Masterox P 100mg/ml', 'sku' => 'ZX-AMP-005', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Drostanolone Propionate ampoules engineered for anti-estrogenic anti-catabolic action.'],
                ['name' => 'Primorox 100mg/ml', 'sku' => 'ZX-AMP-006', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Methenolone Enanthate injectable for smooth, non-aromatizing tissue development.'],
                ['name' => 'Boldrox 200mg/ml', 'sku' => 'ZX-AMP-007', 'dosage' => '200mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Boldenone Undecylenate ampoules supporting steady appetite and endurance.'],
                ['name' => 'Testorox E 250mg/ml', 'sku' => 'ZX-AMP-008', 'dosage' => '250mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Testosterone Enanthate sterile injectable solution for sustained serum concentration.'],
                ['name' => 'Nandrorox F 100mg/ml', 'sku' => 'ZX-AMP-009', 'dosage' => '100mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Nandrolone Phenylpropionate short-acting ester for controlled recovery support.'],
                ['name' => 'Trenrox E 200mg/ml', 'sku' => 'ZX-AMP-010', 'dosage' => '200mg/ml', 'pack' => '10 Ampoules x 1ml', 'desc' => 'Trenbolone Enanthate long ester formulation designed for reduced injection frequency.'],
            ],
            'HGH' => [
                ['name' => 'Somatropin 10IU', 'sku' => 'ZX-HGH-001', 'dosage' => '10IU/vial', 'pack' => '10 Vials + Diluent', 'desc' => 'Human Growth Hormone rDNA 191 amino acid sequence identical to endogenous GH.'],
                ['name' => 'Zerotropin 12IU', 'sku' => 'ZX-HGH-002', 'dosage' => '12IU/vial', 'pack' => '10 Vials + Bacteriostatic Water', 'desc' => 'High purity Somatropin engineered for cellular regeneration and IGF-1 stimulation.'],
                ['name' => 'Norditropin 15IU', 'sku' => 'ZX-HGH-003', 'dosage' => '15IU/pen', 'pack' => '1 Prefilled Pen', 'desc' => 'Premixed Somatropin liquid formulation for precise micro-dosing convenience.'],
                ['name' => 'Genotropin 16IU', 'sku' => 'ZX-HGH-004', 'dosage' => '16IU/cartridge', 'pack' => '5 Cartridges', 'desc' => 'Two-chamber lyophilized HGH cartridge for effortless mixing and stability.'],
                ['name' => 'Humatrope 18IU', 'sku' => 'ZX-HGH-005', 'dosage' => '18IU/vial', 'pack' => '1 Kit (18IU)', 'desc' => 'Lyophilized Human Growth Hormone for clinical growth support and metabolic regulation.'],
                ['name' => 'Omnitrope 10IU', 'sku' => 'ZX-HGH-006', 'dosage' => '10IU/vial', 'pack' => '10 Vials', 'desc' => 'Highly refined Somatropin powder for metabolic lipolysis and skin elasticity.'],
                ['name' => 'Saizen 20IU', 'sku' => 'ZX-HGH-007', 'dosage' => '20IU/vial', 'pack' => '5 Vials + Solvent', 'desc' => 'Concentrated Somatropin formulation for rapid tissue restoration and bone density.'],
                ['name' => 'Hygetropin 8IU', 'sku' => 'ZX-HGH-008', 'dosage' => '8IU/vial', 'pack' => '25 Vials Box', 'desc' => 'Pharmaceutical grade recombinant human growth hormone for muscle maintenance.'],
                ['name' => 'Jintropin 10IU', 'sku' => 'ZX-HGH-009', 'dosage' => '10IU/vial', 'pack' => '10 Vials', 'desc' => 'Secretion technology human growth hormone ensuring optimal stability and zero residue.'],
                ['name' => 'Ansomone 10IU', 'sku' => 'ZX-HGH-010', 'dosage' => '10IU/vial', 'pack' => '10 Vials + WFI', 'desc' => 'Freeze-dried 191 aa sequence rHGH for enhanced protein bio-synthesis.'],
            ],
            'Peptides' => [
                ['name' => 'BPC-157 5mg', 'sku' => 'ZX-PEP-001', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Body Protection Compound-157 peptide for tendon, ligament, and gut repair.'],
                ['name' => 'TB-500 5mg', 'sku' => 'ZX-PEP-002', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Thymosin Beta-4 synthetic peptide facilitating actin regulation and cell migration.'],
                ['name' => 'CJC-1295 DAC 2mg', 'sku' => 'ZX-PEP-003', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'GHRH analogue with Drug Affinity Complex extending plasma half-life to 8 days.'],
                ['name' => 'Ipamorelin 2mg', 'sku' => 'ZX-PEP-004', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'Selective Ghrelin/Growth Hormone secretagogue without cortisol or prolactin elevation.'],
                ['name' => 'GHRP-6 5mg', 'sku' => 'ZX-PEP-005', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Growth Hormone Releasing Peptide-6 stimulating pituitary GH secretion and appetite.'],
                ['name' => 'GHRP-2 5mg', 'sku' => 'ZX-PEP-006', 'dosage' => '5mg/vial', 'pack' => '5 Vials', 'desc' => 'Second generation GHRP delivering potent somatotrop response and fat oxidation.'],
                ['name' => 'Melanotan II 10mg', 'sku' => 'ZX-PEP-007', 'dosage' => '10mg/vial', 'pack' => '1 Vial', 'desc' => 'Synthetic alpha-melanocyte stimulating hormone analogue for skin pigmentation.'],
                ['name' => 'Sermorelin 2mg', 'sku' => 'ZX-PEP-008', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'GHRH 1-29 peptide fragment stimulating natural endogenous pituitary pulse.'],
                ['name' => 'PEG-MGF 2mg', 'sku' => 'ZX-PEP-009', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'Pegylated Mechano Growth Factor for muscle stem cell activation and localized repair.'],
                ['name' => 'Hexarelin 2mg', 'sku' => 'ZX-PEP-010', 'dosage' => '2mg/vial', 'pack' => '5 Vials', 'desc' => 'Hexapeptide growth hormone secretagogue with strong cardioprotective properties.'],
            ],
            'Injectables 10 ml' => [
                ['name' => 'Testorox Enanthate 10ml', 'sku' => 'ZX-VIAL-001', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Testosterone Enanthate multi-dose vial formulated in USP grade castor oil base.'],
                ['name' => 'Testorox Cypionate 10ml', 'sku' => 'ZX-VIAL-002', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Testosterone Cypionate long ester 10ml vial providing stable serum levels.'],
                ['name' => 'Decarox 250 10ml', 'sku' => 'ZX-VIAL-003', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Nandrolone Decanoate high concentration 10ml multi-dose sterile solution.'],
                ['name' => 'Boldenone Undecylenate 10ml', 'sku' => 'ZX-VIAL-004', 'dosage' => '300mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Equipoise 300mg/ml injectable solution engineered for smooth vascular density.'],
                ['name' => 'Trenrox Hexa 10ml', 'sku' => 'ZX-VIAL-005', 'dosage' => '100mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Trenbolone Hexahydrobenzylcarbonate (Parabolan ester) 10ml vial formulation.'],
                ['name' => 'Sustarox 250 10ml', 'sku' => 'ZX-VIAL-006', 'dosage' => '250mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Multi-ester Testosterone blend in a 10ml multidose vial with benzyl alcohol preservative.'],
                ['name' => 'Masterox E 200 10ml', 'sku' => 'ZX-VIAL-007', 'dosage' => '200mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Drostanolone Enanthate 200mg/ml long ester vial for prolonged anti-estrogenic conditioning.'],
                ['name' => 'Primobolan Depot 100 10ml', 'sku' => 'ZX-VIAL-008', 'dosage' => '100mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Methenolone Enanthate 100mg/ml 10ml vial offering smooth intramuscular absorption.'],
                ['name' => 'Trenbolone Tri-Blend 10ml', 'sku' => 'ZX-VIAL-009', 'dosage' => '150mg/ml', 'pack' => '10 ml Vial', 'desc' => 'Acetate, Enanthate, and Hexa Trenbolone tri-ester blend for continuous receptor saturation.'],
                ['name' => 'Mass-Stack Injection 10ml', 'sku' => 'ZX-VIAL-010', 'dosage' => '400mg/ml', 'pack' => '10 ml Vial', 'desc' => 'High-potency synergized compound containing Testosterone, Deca, and Boldenone esters.'],
            ],
        ];

        $allCreatedProducts = [];

        foreach ($productsByCat as $catName => $products) {
            $cat = $createdCategories[$catName];

            foreach ($products as $p) {
                $product = Product::create([
                    'category_id' => $cat->id,
                    'name' => $p['name'],
                    'slug' => Str::slug($p['name']),
                    'sku' => $p['sku'],
                    'dosage_form' => $p['dosage'],
                    'pack_size' => $p['pack'],
                    'description' => $p['desc'],
                    'chemical_characteristics' => "Chemical Name: " . $p['name'] . "\nFormula: C19H28O2 (USP Grade Standard)\nMolar Mass: 288.42 g/mol\nPurity Index: >= 99.4% HPLC Tested\nAppearance: Crystalline Micro-particulate powder / Sterile Clear Carrier Solution\nSolubility: Soluble in ethanol, benzyl benzoate, and sesame oil.",
                    'side_effects' => "Possible mild side effects include androgenic reactions (acne, mild hair thinning in genetically predisposed individuals), lipid profile alterations (temporary elevation of LDL), and transient endogenous hormone suppression. Monitor BP and liver enzymes during extended application periods.",
                    'administration_uses' => "Recommended Protocol: Administer under medical supervision or qualified therapeutic guidelines. Store between 15°C to 25°C protected from direct sunlight. Do not freeze. Verify scratch security code on official authentication portal before first use.",
                    'image_path' => 'images/products/' . Str::slug($p['name']) . '.jpg',
                    'is_active' => true,
                ]);

                $allCreatedProducts[] = $product;
            }
        }

        // 4. Seed 100 Product Verifications
        $batches = ['ZX-2026-B1', 'ZX-2026-B2', 'ZX-2026-B3', 'ZX-2026-B4', 'ZX-2026-B5'];

        // Known verification codes specified in requirements
        $knownCodes = ['ZX-8829-AB41', 'ZX-9921-DF32', 'ZX-1044-KL89', 'ZX-7734-MN22', 'ZX-3321-OP90'];

        $count = 0;
        foreach ($allCreatedProducts as $product) {
            // Add 2 verifications per product = 100 total
            for ($i = 1; $i <= 2; $i++) {
                $count++;
                if (isset($knownCodes[$count - 1])) {
                    $code = $knownCodes[$count - 1];
                } else {
                    $code = 'ZX-' . rand(1000, 9999) . '-' . strtoupper(Str::random(4));
                }

                $batch = $batches[($count % count($batches))];
                $isVerified = ($count % 5 === 0); // Mark 20% as previously verified

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

        // 5. Seed Site Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Zerox Pharmaceuticals Ltd', 'group' => 'general'],
            ['key' => 'company_name', 'value' => 'Zerox Pharmaceuticals Ltd', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+91 11 27023256', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'support@zzerox.com', 'group' => 'contact'],
            ['key' => 'company_address', 'value' => 'Plot No. 42, Industrial Area Phase II, New Delhi, India - 110020', 'group' => 'contact'],
            ['key' => 'hero_title', 'value' => 'Precision Engineering in Pharmaceutical Innovation', 'group' => 'banners'],
            ['key' => 'hero_subtitle', 'value' => 'World-Class Anabolic Steroids, Peptides, and rDNA Human Growth Hormone Certified Under Global GMP Standards.', 'group' => 'banners'],
            ['key' => 'meta_title', 'value' => 'Zerox Pharmaceuticals - Genuine Pharmaceutical Products & Product Authentication', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Official portal of Zerox Pharmaceuticals. Verify product authenticity using our scratch code system and explore high-purity tablets, injectables, HGH, and peptides.', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'Zerox Pharmaceuticals, Zerox anabolic, Anavar, Sustanon, Somatropin, BPC-157, Product Verification', 'group' => 'seo'],
            ['key' => 'google_analytics', 'value' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZEROXDEMO12"></script><script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-ZEROXDEMO12");</script>', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}
