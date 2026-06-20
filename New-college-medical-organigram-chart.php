<?php
/**
 * Plugin Name: RCMC Organigram Chart
 * Plugin URI:  https://github.com/mkError420/RCMC-Organigram--plugin-
 * Description: A premium, highly customizable, responsive Educational/Medical College Organigram matching professional structure with dynamic counts, search, and detail inspections.
 * Version:     1.2.0
 * Author:      RCMC ICT Department
 * Author URI:  rcmc.com.bd
 * License:     GPLv2 or later
 * Text Domain: https://github.com/mkError420
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Class for College Organigram Plugin
 */
class WR_College_Organigram {

	/**
	 * Constructor to hooks and initial loads
	 */
	public function __construct() {
		// Register styles and scripts on frontend
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );

		// Register shortcode
		add_shortcode( 'college_organigram', array( $this, 'render_shortcode' ) );

		// Register Admin Panel
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Register Admin Settings Menu
	 */
	public function add_admin_menu() {
		add_menu_page(
			'Organigram Settings',
			'Colg. Organigram',
			'manage_options',
			'college-medical-organigram-chart',
			array( $this, 'render_admin_options_page' ),
			'dashicons-networking',
			80
		);
	}

	/**
	 * Register options in Database
	 */
	public function register_settings() {
		register_setting( 'college-medical-organigram-chart_settings_group', 'college-medical-organigram-chart_data' );
		register_setting( 'college-medical-organigram-chart_settings_group', 'college-medical-organigram-chart_custom_css' );
	}

	/**
	 * Enqueue static styles on frontend
	 */
	public function enqueue_frontend_scripts() {
		// Inline styling inside the render to guarantee perfect styling even if styles fail, 
		// but we can register standard hooks as well.
	}

	/**
	 * Helper to retrieve raw or saved organigram data
	 */
	private function get_organigram_data() {
		$saved = get_option( 'college-medical-organigram-chart_data' );
		if ( ! empty( $saved ) ) {
			$decoded = json_decode( $saved, true );
			if ( is_array( $decoded ) ) {
				return $decoded;
			}
		}

		// Return standard initial dataset set during build
		return json_decode( '{
  "title": "College/Hospital Organizational Chart",
  "rootNodes": {
    "principal": {
      "id": "principal",
      "name": "PRINCIPAL",
      "subtitle": "Personal-05",
      "colorTheme": "navy",
      "subordinates": [
        {
          "id": "p1",
          "name": "Principal",
          "count": 1
        },
        {
          "id": "p2",
          "name": "PA to Principal",
          "count": 1
        },
        {
          "id": "p3",
          "name": "Computer Operator",
          "count": 1
        },
        {
          "id": "p4",
          "name": "MLSS",
          "count": 2
        }
      ],
      "childrenIds": [
        "administration",
        "academic"
      ]
    },
    "vicePrincipal": {
      "id": "vice_principal",
      "name": "VICE-PRINCIPAL",
      "subtitle": "Personal-02",
      "colorTheme": "green",
      "subordinates": [
        {
          "id": "vp1",
          "name": "Vice-Principal",
          "count": 1
        },
        {
          "id": "vp2",
          "name": "MLSS",
          "count": 1
        }
      ]
    }
  },
  "categories": [
    {
      "id": "administration",
      "name": "CATEGORY-1: ADMINISTRATION",
      "colorTheme": "blue",
      "departments": [
        {
          "id": "class_01",
          "code": "CLASS-01",
          "name": "OFFICE",
          "colorTheme": "blue",
          "items": [
            {
              "id": "c1_1",
              "name": "Secretary",
              "count": 1
            },
            {
              "id": "c1_2",
              "name": "HR",
              "count": 1
            },
            {
              "id": "c1_3",
              "name": "Senior Asstt. Sec",
              "count": 1
            },
            {
              "id": "c1_4",
              "name": "Manager MIS",
              "count": 1
            },
            {
              "id": "c1_5",
              "name": "D.M. Admin",
              "count": 1
            },
            {
              "id": "c1_6",
              "name": "UDA",
              "count": 2
            },
            {
              "id": "c1_7",
              "name": "Office Assistant",
              "count": 3
            },
            {
              "id": "c1_8",
              "name": "Computer Oper",
              "count": 2
            },
            {
              "id": "c1_9",
              "name": "Store Keeper",
              "count": 1
            },
            {
              "id": "c1_10",
              "name": "Imam",
              "count": 1
            },
            {
              "id": "c1_11",
              "name": "Muazzin",
              "count": 1
            },
            {
              "id": "c1_12",
              "name": "Class Attendent",
              "count": 5
            },
            {
              "id": "c1_13",
              "name": "Messenger",
              "count": 1
            },
            {
              "id": "c1_14",
              "name": "Plumber",
              "count": 1
            },
            {
              "id": "c1_15",
              "name": "Gardener",
              "count": 2
            },
            {
              "id": "c1_16",
              "name": "Driver",
              "count": 8
            },
            {
              "id": "c1_17",
              "name": "Bus Helper",
              "count": 3
            },
            {
              "id": "c1_18",
              "name": "Lift Man",
              "count": 2
            },
            {
              "id": "c1_19",
              "name": "MLSS",
              "count": 10
            },
            {
              "id": "c1_20",
              "name": "Cleaner",
              "count": 10
            }
          ]
        },
        {
          "id": "class_02",
          "code": "CLASS-02",
          "name": "ACCOUNTS",
          "colorTheme": "blue",
          "items": [
            {
              "id": "c2_1",
              "name": "Chief Accountant",
              "count": 1
            },
            {
              "id": "c2_2",
              "name": "Internal Auditor",
              "count": 1
            },
            {
              "id": "c2_3",
              "name": "D.M Account",
              "count": 1
            },
            {
              "id": "c2_4",
              "name": "Asstt. Account",
              "count": 1
            },
            {
              "id": "c2_5",
              "name": "Cashier",
              "count": 2
            }
          ]
        },
        {
          "id": "class_03",
          "code": "CLASS-03",
          "name": "LIBRARY",
          "colorTheme": "blue",
          "items": [
            {
              "id": "c3_1",
              "name": "Librarian",
              "count": 1
            },
            {
              "id": "c3_2",
              "name": "Asstt. Librarian",
              "count": 2
            },
            {
              "id": "c3_3",
              "name": "Library Attendent",
              "count": 2
            },
            {
              "id": "c3_4",
              "name": "[SEPARATOR] SECURITY SERVICES",
              "count": 25
            },
            {
              "id": "c3_5",
              "name": "Security Guard",
              "count": 25
            }
          ]
        },
        {
          "id": "class_04",
          "code": "CLASS-04",
          "name": "HOSTEL",
          "colorTheme": "blue",
          "items": [
            {
              "id": "c4_1",
              "name": "Hostel Super",
              "count": 1
            },
            {
              "id": "c4_2",
              "name": "Assistant Hostel Super",
              "count": 3
            },
            {
              "id": "c4_3",
              "name": "Hostel Assistant",
              "count": 3
            },
            {
              "id": "c4_4",
              "name": "House Keeper",
              "count": 1
            },
            {
              "id": "c4_5",
              "name": "Electrician",
              "count": 1
            },
            {
              "id": "c4_6",
              "name": "Cook",
              "count": 7
            },
            {
              "id": "c4_7",
              "name": "Table boy",
              "count": 8
            },
            {
              "id": "c4_8",
              "name": "MLSS",
              "count": 1
            },
            {
              "id": "c4_9",
              "name": "Cleaner",
              "count": 22
            }
          ]
        }
      ]
    },
    {
      "id": "academic",
      "name": "CATEGORY-2: ACADEMIC",
      "colorTheme": "green",
      "subCategories": [
        {
          "id": "pre_clinical",
          "name": "SUB-CATEGORY-1: PRE-CLINICAL DEPARTMENT",
          "colorTheme": "green",
          "departments": [
            {
              "id": "pc_anatomy",
              "code": "01.",
              "name": "ANATOMY",
              "colorTheme": "green",
              "items": [
                {
                  "id": "pc1_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "pc1_2",
                  "name": "Associate Professor",
                  "count": 2
                },
                {
                  "id": "pc1_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "pc1_4",
                  "name": "Curator",
                  "count": 1
                },
                {
                  "id": "pc1_5",
                  "name": "Lecturer",
                  "count": 12
                },
                {
                  "id": "pc1_6",
                  "name": "Medical Technologist (Lab)",
                  "count": 1
                },
                {
                  "id": "pc1_7",
                  "name": "Lab Attendent",
                  "count": 2
                },
                {
                  "id": "pc1_8",
                  "name": "Medical Technologist (Lab)",
                  "count": 1
                },
                {
                  "id": "pc1_9",
                  "name": "Lab Attendent",
                  "count": 2
                },
                {
                  "id": "pc1_10",
                  "name": "Dom",
                  "count": 2
                }
              ]
            },
            {
              "id": "pc_physiology",
              "code": "02.",
              "name": "PHYSIOLOGY",
              "colorTheme": "green",
              "items": [
                {
                  "id": "pc2_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "pc2_2",
                  "name": "Associate Professor",
                  "count": 2
                },
                {
                  "id": "pc2_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "pc2_4",
                  "name": "Lecturer",
                  "count": 6
                },
                {
                  "id": "pc2_5",
                  "name": "Medical Technologist (Lab)",
                  "count": 1
                },
                {
                  "id": "pc2_6",
                  "name": "Lab Attendent",
                  "count": 2
                }
              ]
            },
            {
              "id": "pc_biochemistry",
              "code": "03.",
              "name": "BIOCHEMISTRY",
              "colorTheme": "green",
              "items": [
                {
                  "id": "pc3_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "pc3_2",
                  "name": "Associate Professor",
                  "count": 2
                },
                {
                  "id": "pc3_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "pc3_4",
                  "name": "Lecturer",
                  "count": 6
                },
                {
                  "id": "pc3_5",
                  "name": "Medical Technologist (Lab)",
                  "count": 1
                },
                {
                  "id": "pc3_6",
                  "name": "Lab Attendent",
                  "count": 2
                }
              ]
            },
            {
              "id": "pc_pharmacology",
              "code": "04.",
              "name": "PHARMACOLOGY",
              "colorTheme": "green",
              "items": [
                {
                  "id": "pc4_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "pc4_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "pc4_3",
                  "name": "Assistant Professor",
                  "count": 2
                },
                {
                  "id": "pc4_4",
                  "name": "Lecturer",
                  "count": 6
                },
                {
                  "id": "pc4_5",
                  "name": "Pharmacist",
                  "count": 1
                },
                {
                  "id": "pc4_6",
                  "name": "Lab Attendent",
                  "count": 2
                },
                {
                  "id": "pc4_7",
                  "name": "Animal Caretaker",
                  "count": 1
                }
              ]
            },
            {
              "id": "pc_pathology",
              "code": "05.",
              "name": "PATHOLOGY",
              "colorTheme": "green",
              "items": [
                {
                  "id": "pc5_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "pc5_2",
                  "name": "Associate Professor",
                  "count": 2
                },
                {
                  "id": "pc5_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "pc5_4",
                  "name": "Lecturer",
                  "count": 6
                },
                {
                  "id": "pc5_5",
                  "name": "Medical Tech (Lab)",
                  "count": 3
                },
                {
                  "id": "pc5_6",
                  "name": "Lab Attendent",
                  "count": 5
                }
              ]
            },
            {
              "id": "pc_microbiology",
              "code": "06.",
              "name": "MICROBIOLOGY",
              "colorTheme": "green",
              "items": [
                {
                  "id": "pc6_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "pc6_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "pc6_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "pc6_4",
                  "name": "Lecturer",
                  "count": 6
                },
                {
                  "id": "pc6_5",
                  "name": "Medical Tech (Lab)",
                  "count": 2
                },
                {
                  "id": "pc6_6",
                  "name": "Lab Attendent",
                  "count": 3
                }
              ]
            },
            {
              "id": "pc_forensic_medicine",
              "code": "07.",
              "name": "FORENSIC MEDICINE",
              "colorTheme": "green",
              "items": [
                {
                  "id": "pc7_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "pc7_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "pc7_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "pc7_4",
                  "name": "Lecturer",
                  "count": 6
                },
                {
                  "id": "pc7_5",
                  "name": "Lab Attendent",
                  "count": 2
                }
              ]
            },
            {
              "id": "pc_community_medicine",
              "code": "08.",
              "name": "COMMUNITY MEDICINE",
              "colorTheme": "green",
              "items": [
                {
                  "id": "pc8_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "pc8_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "pc8_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "pc8_4",
                  "name": "Lecturer",
                  "count": 6
                },
                {
                  "id": "pc8_5",
                  "name": "Technician",
                  "count": 1
                },
                {
                  "id": "pc8_6",
                  "name": "Driver (RFST)",
                  "count": 1
                }
              ]
            }
          ]
        },
        {
          "id": "clinical",
          "name": "SUB-CATEGORY-2: CLINICAL DEPARTMENT",
          "colorTheme": "yellow",
          "departments": [
            {
              "id": "cl_medicine",
              "code": "01.",
              "name": "MEDICINE",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl1_1",
                  "name": "Professor",
                  "count": 4
                },
                {
                  "id": "cl1_2",
                  "name": "Associate Professor",
                  "count": 3
                },
                {
                  "id": "cl1_3",
                  "name": "Assistant Professor",
                  "count": 4
                },
                {
                  "id": "cl1_4",
                  "name": "Resident Physician",
                  "count": 1
                },
                {
                  "id": "cl1_5",
                  "name": "Registrar",
                  "count": 4
                }
              ]
            },
            {
              "id": "cl_orthopaedics",
              "code": "02.",
              "name": "ORTHOPAEDICS",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl2_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "cl2_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl2_3",
                  "name": "Assistant Professor",
                  "count": 2
                },
                {
                  "id": "cl2_4",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_paediatrics",
              "code": "03.",
              "name": "PAEDIATRICS",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl3_1",
                  "name": "Professor",
                  "count": 2
                },
                {
                  "id": "cl3_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl3_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "cl3_4",
                  "name": "Registrar",
                  "count": 2
                }
              ]
            },
            {
              "id": "cl_oncology",
              "code": "04.",
              "name": "ONCOLOGY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl4_1",
                  "name": "Professor",
                  "count": 2
                },
                {
                  "id": "cl4_2",
                  "name": "Associate Professor",
                  "count": 2
                },
                {
                  "id": "cl4_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "cl4_4",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_psychiatry",
              "code": "05.",
              "name": "PSYCHIATRY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl5_1",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl5_2",
                  "name": "Assistant Professor",
                  "count": 1
                },
                {
                  "id": "cl5_3",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_pediatrics_surgery",
              "code": "06.",
              "name": "PEDIATRICS SURGERY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl6_1",
                  "name": "Professor/Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl6_2",
                  "name": "Assistant Professor",
                  "count": 1
                },
                {
                  "id": "cl6_3",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_dermatology",
              "code": "07.",
              "name": "DERMATOLOGY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl7_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "cl7_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl7_3",
                  "name": "Assistant Professor",
                  "count": 1
                },
                {
                  "id": "cl7_4",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_urology",
              "code": "08.",
              "name": "UROLOGY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl8_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "cl8_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl8_3",
                  "name": "Assistant Professor",
                  "count": 2
                },
                {
                  "id": "cl8_4",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_blood_bank",
              "code": "09.",
              "name": "BLOOD BANK",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl9_1",
                  "name": "Professor/Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl9_2",
                  "name": "Assistant Professor",
                  "count": 2
                },
                {
                  "id": "cl9_3",
                  "name": "Lab Asstt.",
                  "count": 4
                }
              ]
            },
            {
              "id": "cl_neurosurgery",
              "code": "10.",
              "name": "NEUROSURGERY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl10_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "cl10_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl10_3",
                  "name": "Assistant Professor",
                  "count": 2
                },
                {
                  "id": "cl10_4",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_neurology",
              "code": "11.",
              "name": "NEUROLOGY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl11_1",
                  "name": "Professor/Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl11_2",
                  "name": "Assistant Professor",
                  "count": 1
                },
                {
                  "id": "cl11_3",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_plastic_surgery_burn",
              "code": "12.",
              "name": "PLASTIC SURGERY & BURN",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl12_1",
                  "name": "Professor/Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl12_2",
                  "name": "Assistant Professor",
                  "count": 2
                },
                {
                  "id": "cl12_3",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_nephrology",
              "code": "13.",
              "name": "NEPHROLOGY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl13_1",
                  "name": "Professor/Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl13_2",
                  "name": "Assistant Professor",
                  "count": 1
                },
                {
                  "id": "cl13_3",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_ent",
              "code": "14.",
              "name": "ENT",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl14_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "cl14_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl14_3",
                  "name": "Assistant Professor",
                  "count": 2
                },
                {
                  "id": "cl14_4",
                  "name": "Resident Surgeon",
                  "count": 1
                },
                {
                  "id": "cl14_5",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_cardiology",
              "code": "15.",
              "name": "CARDIOLOGY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl15_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "cl15_2",
                  "name": "Associate Professor",
                  "count": 2
                },
                {
                  "id": "cl15_3",
                  "name": "Assistant Professor",
                  "count": 2
                },
                {
                  "id": "cl15_4",
                  "name": "Registrar",
                  "count": 2
                }
              ]
            },
            {
              "id": "cl_ophthalmology",
              "code": "16.",
              "name": "OPHTHALMOLOGY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl16_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "cl16_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl16_3",
                  "name": "Assistant Professor",
                  "count": 2
                },
                {
                  "id": "cl16_4",
                  "name": "Resident Surgeon",
                  "count": 1
                },
                {
                  "id": "cl16_5",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_icu",
              "code": "17.",
              "name": "ICU",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl17_1",
                  "name": "Professor/Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl17_2",
                  "name": "Assistant Professor",
                  "count": 1
                },
                {
                  "id": "cl17_3",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_anaesthesiology",
              "code": "18.",
              "name": "ANAESTHESIOLOGY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl18_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "cl18_2",
                  "name": "Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl18_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "cl18_4",
                  "name": "Registrar",
                  "count": 2
                }
              ]
            },
            {
              "id": "cl_nicu_picu",
              "code": "19.",
              "name": "NICU-PICU",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl19_1",
                  "name": "Professor/Associate Professor",
                  "count": 1
                },
                {
                  "id": "cl19_2",
                  "name": "Assistant Professor",
                  "count": 1
                },
                {
                  "id": "cl19_3",
                  "name": "Registrar",
                  "count": 1
                }
              ]
            },
            {
              "id": "cl_radiology_imaging",
              "code": "20.",
              "name": "RADIOLOGY & IMAGING",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl20_1",
                  "name": "Professor",
                  "count": 1
                },
                {
                  "id": "cl20_2",
                  "name": "Associate Professor",
                  "count": 2
                },
                {
                  "id": "cl20_3",
                  "name": "Assistant Professor",
                  "count": 2
                }
              ]
            },
            {
              "id": "cl_surgery",
              "code": "21.",
              "name": "SURGERY",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl21_1",
                  "name": "Professor",
                  "count": 3
                },
                {
                  "id": "cl21_2",
                  "name": "Associate Professor",
                  "count": 2
                },
                {
                  "id": "cl21_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "cl21_4",
                  "name": "Resident Surgeon",
                  "count": 1
                },
                {
                  "id": "cl21_5",
                  "name": "Registrar",
                  "count": 4
                }
              ]
            },
            {
              "id": "cl_gynae_obst",
              "code": "22.",
              "name": "GYNAE & OBST",
              "colorTheme": "yellow",
              "items": [
                {
                  "id": "cl22_1",
                  "name": "Professor",
                  "count": 3
                },
                {
                  "id": "cl22_2",
                  "name": "Associate Professor",
                  "count": 2
                },
                {
                  "id": "cl22_3",
                  "name": "Assistant Professor",
                  "count": 3
                },
                {
                  "id": "cl22_4",
                  "name": "Resident Surgeon",
                  "count": 1
                },
                {
                  "id": "cl22_5",
                  "name": "Registrar",
                  "count": 5
                }
              ]
            }
          ]
        }
      ]
    }
  ],
  "summaryNote": "Numbers in headings indicate total personnel in respective unit/department."
}', true );
	}

	/**
	 * Render Shortcode [college_organigram]
	 */
	public function render_shortcode( $atts ) {
		$data = $this->get_organigram_data();

		$custom_css = get_option( 'college-medical-organigram-chart_custom_css', '' );

		// Fetch totals
		$totals = $this->calculate_totals( $data );

		// Start buffer for shortcode output
		ob_start();
		?>
		<!-- WordPress College Organigram Styling -->
		<style>
			.org-container {
				font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
				color: #333333;
				background: #fcfcfc;
				border: 1px solid #e5e7eb;
				border-radius: 12px;
				padding: 24px;
				margin: 20px 0;
				max-width: 100%;
				overflow-x: auto;
				box-sizing: border-box;
			}
			.org-interactive-bar {
				display: flex;
				justify-content: space-between;
				align-items: center;
				flex-wrap: wrap;
				gap: 12px;
				margin-bottom: 24px;
				border-bottom: 1px solid #f0f0f0;
				padding-bottom: 16px;
			}

			.org-filter-btn {
				padding: 6px 12px;
				background: #f3f4f6;
				border: 1px solid #e5e7eb;
				cursor: pointer;
				font-size: 13px;
				border-radius: 6px;
				transition: all 0.2s;
			}
			.org-filter-btn.active {
				background: #1e3a8a;
				color: #ffffff;
				border-color: #1e3a8a;
			}
			
			/* Trees and lines */
			.org-tree {
				min-width: 1100px;
				margin: 0 auto;
			}
			.org-root-row {
				display: flex;
				justify-content: center;
				gap: 80px;
				position: relative;
				margin-bottom: 50px;
				align-items: stretch;
			}
			.org-root-node {
				border-radius: 8px;
				text-align: center;
				font-weight: bold;
				min-width: 240px;
				box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
				border: 2px solid;
				overflow: hidden;
			}
			.org-root-header {
				padding: 10px 15px;
				font-size: 16px;
				text-transform: uppercase;
				color: white;
			}
			.org-root-subtitle {
				font-size: 12px;
				opacity: 0.9;
				margin-top: 2px;
			}
			.org-root-items {
				background: white;
				padding: 10px;
				font-size: 13px;
				display: flex;
				flex-wrap: wrap;
				gap: 6px;
				justify-content: center;
			}
			.org-root-item {
				background: #f3f4f6;
				border: 1px solid #d1d5db;
				border-radius: 4px;
				padding: 3px 8px;
				font-size: 11px;
				white-space: nowrap;
			}
			
			.org-categories-row {
				display: flex;
				gap: 30px;
				justify-content: space-between;
			}
			.org-category-wrap {
				flex: 1;
				border-radius: 8px;
				border: 1px solid #e5e7eb;
				padding: 16px;
				background: #ffffff;
			}
			.org-category-title {
				font-size: 15px;
				font-weight: 700;
				padding: 8px 12px;
				color: white;
				border-radius: 6px;
				margin-bottom: 16px;
				text-transform: uppercase;
				letter-spacing: 0.5px;
				text-align: center;
			}
			
			.org-subcategories-row {
				display: flex;
				direction: ltr;
				gap: 20px;
			}
			.org-subcategory {
				flex: 1;
			}
			.org-subcategory-title {
				font-size: 12px;
				font-weight: 700;
				border: 1px solid;
				padding: 6px 10px;
				text-align: center;
				border-radius: 4px;
				margin-bottom: 16px;
				text-transform: uppercase;
			}
			
			.org-departments-grid {
				display: grid;
				gap: 12px;
			}
			.org-dept-admin {
				grid-template-columns: 1fr;
			}
			.org-dept-preclinical {
				grid-template-columns: repeat(2, 1fr);
			}
			.org-dept-clinical {
				grid-template-columns: repeat(3, 1fr);
			}
			
			.org-dept-card {
				border: 1px solid #d1d5db;
				border-radius: 6px;
				overflow: hidden;
				background: white;
				font-size: 11px;
				box-shadow: 0 1px 2px rgba(0,0,0,0.05);
				transition: all 0.2s ease;
			}
			.org-dept-card:hover {
				transform: translateY(-2px);
				box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
			}
			.org-dept-header {
				padding: 6px 8px;
				font-weight: bold;
				color: white;
				display: flex;
				justify-content: space-between;
				align-items: center;
				font-size: 11.5px;
			}
			.org-dept-header-count {
				background: rgba(255, 255, 255, 0.25);
				padding: 1px 5px;
				border-radius: 3px;
				font-size: 10px;
			}
			
			.org-dept-list {
				list-style: none;
				margin: 0;
				padding: 6px 8px;
			}
			.org-dept-item {
				display: flex;
				justify-content: space-between;
				align-items: center;
				padding: 3px 0;
				border-bottom: 1px solid #f3f4f6;
			}
			.org-dept-item:last-child {
				border-bottom: none;
				padding-bottom: 0px;
			}
			.org-dept-item-separator {
				font-weight: bold;
				font-size: 11px;
				border-top: 1px solid #dedede;
				margin-top: 4px;
				padding-top: 6px;
				background: #f3f4f6;
				padding-bottom: 2px;
				text-align: center;
			}
			.org-dept-item-separator span {
				display: none;
			}
			
			.org-summary-box {
				border: 2px solid #e5e7eb;
				border-radius: 8px;
				padding: 14px;
				background: #ffffff;
				width: 280px;
				margin-top: 24px;
			}
			.org-summary-title {
				font-weight: bold;
				font-size: 14px;
				border-bottom: 1px solid #e5e7eb;
				padding-bottom: 4px;
				margin-bottom: 8px;
				text-transform: uppercase;
				text-align: center;
			}
			.org-summary-row {
				display: flex;
				justify-content: space-between;
				font-size: 12px;
				margin: 4px 0;
			}
			.org-summary-total {
				font-weight: bold;
				font-size: 13px;
				border-top: 1px solid #e5e7eb;
				padding-top: 6px;
				margin-top: 6px;
			}
			
			.org-note-box {
				border: 1px solid #bfdbfe;
				border-radius: 6px;
				padding: 10px 14px;
				background: #eff6ff;
				margin-top: 24px;
				font-size: 11.5px;
				color: #1e40af;
				max-width: 400px;
			}
			
			/* Theme colors mapping */
			.theme-navy { border-color: #111827; }
			.theme-navy .org-root-header { background: #111827; }
			.theme-blue { border-color: #1e3a8a; }
			.theme-blue .org-root-header { background: #1e3a8a; }
			.theme-green { border-color: #064e3b; }
			.theme-green .org-root-header { background: #064e3b; }
			
			.bg-theme-blue { background: #1e3a8a; }
			.bg-theme-green { background: #0f766e; }
			.bg-theme-lightgreen { background: #15803d; border-color: #166534; color: #166534; }
			.bg-theme-yellow { background: #b45309; }
			
			.text-theme-blue { color: #1e3a8a; border-color: #3b82f6; }
			.text-theme-green { color: #047857; border-color: #10b981; }
			.text-theme-yellow { color: #b45309; border-color: #f59e0b; }
			
			.dept-bg-blue { background: #1e3a8a; }
			.dept-bg-green { background: #166534; }
			.dept-bg-yellow { background: #d97706; }
			
			/* Mobile adjustments */
			@media (max-width: 1024px) {
				.org-categories-row {
					flex-direction: column;
				}
				.org-subcategories-row {
					flex-direction: column;
				}
				.org-dept-preclinical, .org-dept-clinical {
					grid-template-columns: repeat(2, 1fr);
				}
				.org-tree {
					min-width: 100%;
				}
				.org-root-row {
					flex-direction: column;
					align-items: center;
					gap: 16px;
				}
			}
			@media (max-width: 640px) {
				.org-dept-admin, .org-dept-preclinical, .org-dept-clinical {
					grid-template-columns: 1fr;
				}
			}
			
			/* Search highlight matches */
			.org-highlight {
				animation: pulse-highlight 1.5s infinite alternate;
				border: 2px solid #ef4444 !important;
			}
			@keyframes pulse-highlight {
				0% { box-shadow: 0 0 5px rgba(239, 68, 68, 0.4); }
				100% { box-shadow: 0 0 15px rgba(239, 68, 68, 0.9); }
			}
			.org-dimmed {
				opacity: 0.25;
			}
			
			/* Beautiful visual decorative lines for desktop */
			#node-principal, #node-vp {
				position: relative;
				overflow: visible;
			}
			#node-principal .org-root-header, #node-vp .org-root-header {
				border-top-left-radius: 6px;
				border-top-right-radius: 6px;
			}
			.org-arrow-p-to-vp {
				position: absolute;
				top: 22px;
				left: 100%;
				width: 80px;
				height: 2px;
				background-color: #ef4444;
				z-index: 10;
			}
			.org-arrow-p-to-vp::after {
				content: "";
				position: absolute;
				right: 0;
				top: -4px;
				width: 0;
				height: 0;
				border-top: 5px solid transparent;
				border-bottom: 5px solid transparent;
				border-left: 7px solid #ef4444;
			}
			.org-arrow-vp-down {
				position: absolute;
				bottom: -30px;
				left: 50%;
				width: 2px;
				height: 30px;
				background-color: #ef4444;
				z-index: 10;
			}
			.org-arrow-vp-down::after {
				content: "";
				position: absolute;
				bottom: 0;
				left: -4px;
				width: 0;
				height: 0;
				border-left: 5px solid transparent;
				border-right: 5px solid transparent;
				border-top: 7px solid #ef4444;
			}
			.org-tree-lines {
				position: relative;
				height: 50px;
				margin-top: -50px;
				margin-bottom: 0;
				pointer-events: none;
				z-index: 5;
			}
			#cat-card-administration {
				flex: 1;
			}
			#cat-card-academic {
				flex: 2.4;
			}
			.org-line-horizontal {
				position: absolute;
				top: 30px;
				left: calc( (100% - 30px) * 0.5 / 3.4 );
				right: calc( (100% - 30px) * 1.2 / 3.4 );
				height: 2px;
				background-color: #ef4444;
				z-index: 9;
			}
			.org-arrow-to-admin {
				position: absolute;
				top: 30px;
				left: calc( (100% - 30px) * 0.5 / 3.4 );
				width: 2px;
				height: 20px;
				background-color: #ef4444;
				z-index: 10;
			}
			.org-arrow-to-admin::after {
				content: "";
				position: absolute;
				bottom: 0;
				left: -4px;
				width: 0;
				height: 0;
				border-left: 5px solid transparent;
				border-right: 5px solid transparent;
				border-top: 7px solid #ef4444;
			}
			.org-arrow-to-academic {
				position: absolute;
				top: 30px;
				right: calc( (100% - 30px) * 1.2 / 3.4 );
				width: 2px;
				height: 20px;
				background-color: #ef4444;
				z-index: 10;
			}
			.org-arrow-to-academic::after {
				content: "";
				position: absolute;
				bottom: 0;
				left: -4px;
				width: 0;
				height: 0;
				border-left: 5px solid transparent;
				border-right: 5px solid transparent;
				border-top: 7px solid #ef4444;
			}
			@media (max-width: 1024px) {
				.org-tree-lines {
					display: none !important;
				}
				.org-root-row {
					margin-bottom: 20px !important;
					flex-direction: column;
					align-items: center;
					gap: 16px;
				}
				.org-arrow-p-to-vp {
					top: 100%;
					left: 50%;
					width: 2px;
					height: 16px;
				}
				.org-arrow-p-to-vp::after {
					bottom: 0;
					left: -4px;
					top: auto;
					right: auto;
					border-top: 7px solid #ef4444;
					border-left: 5px solid transparent;
					border-right: 5px solid transparent;
					border-bottom: none;
				}
				.org-arrow-vp-down {
					bottom: -20px;
					height: 20px;
				}
				#cat-card-administration,
				#cat-card-academic {
					flex: none !important;
					width: 100% !important;
				}
				#cat-card-administration {
					position: relative;
					overflow: visible;
				}
				#cat-card-administration::after {
					content: "";
					position: absolute;
					bottom: -30px;
					left: 50%;
					width: 2px;
					height: 30px;
					background-color: #ef4444;
					z-index: 10;
				}
				#cat-card-administration::before {
					content: "";
					position: absolute;
					bottom: -30px;
					left: calc(50% - 4px);
					width: 0;
					height: 0;
					border-left: 5px solid transparent;
					border-right: 5px solid transparent;
					border-top: 7px solid #ef4444;
					z-index: 10;
				}
				/* Hide vertical connector from Admin to Academic when filtered */
				.filter-admin #cat-card-administration::after,
				.filter-admin #cat-card-administration::before {
					display: none !important;
				}
			}

			/* Department Card Modal Clickable States & Popup styling */
			.clickable-dept-card {
				cursor: pointer;
				transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s ease, border-color 0.2s ease;
			}
			.clickable-dept-card:hover {
				transform: translateY(-3px) scale(1.015);
				box-shadow: 0 10px 20px -5px rgba(0,0,0,0.08), 0 8px 8px -6px rgba(0,0,0,0.04);
			}
			.org-dept-preclinical .clickable-dept-card:hover {
				border-color: #10b981 !important;
			}
			.org-dept-clinical .clickable-dept-card:hover {
				border-color: #d97706 !important;
			}
			.org-modal-overlay {
				position: fixed;
				top: 0;
				left: 0;
				width: 100vw;
				height: 100vh;
				background-color: rgba(15, 23, 42, 0.45);
				backdrop-filter: blur(5px);
				z-index: 99999;
				display: none;
				align-items: center;
				justify-content: center;
				opacity: 0;
				transition: opacity 0.25s ease-out;
			}
			.org-modal-overlay.active {
				display: flex;
				opacity: 1;
			}
			.org-modal-content {
				background: #ffffff;
				border-radius: 14px;
				width: 90%;
				max-width: 440px;
				box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
				overflow: hidden;
				position: relative;
				transform: scale(0.92);
				transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
				box-sizing: border-box;
				border: 1px solid #e2e8f0;
			}
			.org-modal-overlay.active .org-modal-content {
				transform: scale(1);
			}
			.org-modal-close {
				position: absolute;
				top: 12px;
				right: 12px;
				background: rgba(255, 255, 255, 0.2);
				border: none;
				color: #ffffff;
				font-size: 16px;
				cursor: pointer;
				width: 28px;
				height: 28px;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				transition: background 0.2s, transform 0.2s;
				padding: 0;
				line-height: 1;
			}
			.org-modal-close:hover {
				background: rgba(255, 255, 255, 0.35);
				transform: rotate(90deg);
			}
			.org-modal-header {
				padding: 18px 24px;
				color: #ffffff;
				font-weight: 800;
				font-size: 16px;
				display: flex;
				justify-content: space-between;
				align-items: center;
				text-transform: uppercase;
				letter-spacing: 0.5px;
			}
			.org-modal-header-count {
				background: rgba(255, 255, 255, 0.25);
				padding: 2px 8px;
				border-radius: 4px;
				font-size: 12px;
				font-weight: bold;
			}
			.org-modal-body {
				padding: 24px;
				max-height: 380px;
				overflow-y: auto;
			}
			.org-modal-list {
				list-style: none;
				margin: 0;
				padding: 0;
			}
			.org-modal-list-item {
				display: flex;
				justify-content: space-between;
				align-items: center;
				padding: 10px 0;
				border-bottom: 1px solid #f1f5f9;
				font-size: 13.5px;
				color: #334155;
			}
			.org-modal-list-item:last-child {
				border-bottom: none;
			}
			.org-modal-list-item-separator {
				font-weight: bold;
				font-size: 12px;
				border-top: 1px solid #e2e8f0;
				margin-top: 10px;
				padding-top: 10px;
				background: #f8fafc;
				padding: 6px 12px;
				border-radius: 6px;
				text-align: center;
				color: #475569;
			}
			
			<?php echo esc_html($custom_css); ?>
		</style>

		<div class="org-container" id="org-board-college-medical-organigram-chart">
			<div class="org-interactive-bar">
				<div style="font-weight:bold; font-size: 16px; color: #1e3a8a;">
					<?php echo esc_html($data['title']); ?>
				</div>
				<div style="display:flex; gap:8px; align-items:center;">
					<button class="org-filter-btn active" onclick="orgFilterCategory(this, 'all')">All</button>
					<button class="org-filter-btn" onclick="orgFilterCategory(this, 'admin')">Admin</button>
					<button class="org-filter-btn" onclick="orgFilterCategory(this, 'academic')">Academic</button>
				</div>
			</div>

			<div class="org-tree">
				<!-- Root Nodes (Principal / Vice Principal) -->
				<div class="org-root-row" id="org-roots-section">
					<?php 
					$principal = $data['rootNodes']['principal']; 
					$vp = $data['rootNodes']['vicePrincipal'];
					?>
					<div class="org-root-node theme-navy" data-node="principal" id="node-principal">
						<div class="org-arrow-p-to-vp"></div>
						<div class="org-root-header">
							<?php echo esc_html($principal['name']); ?>
							<div class="org-root-subtitle">(<?php echo esc_html($principal['subtitle']); ?>)</div>
						</div>
						<div class="org-root-items">
							<?php foreach($principal['subordinates'] as $sub): ?>
								<div class="org-root-item" data-search-text="<?php echo esc_attr(strtolower($sub['name'])); ?>">
									<?php echo esc_html($sub['name']); ?>-<?php echo sprintf('%02d', $sub['count']); ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="org-root-node bg-theme-lightgreen" data-node="vice_principal" id="node-vp" style="border-color: #166534;">
						<div class="org-arrow-vp-down"></div>
						<div class="org-root-header" style="background: #166534;">
							<?php echo esc_html($vp['name']); ?>
							<div class="org-root-subtitle">(<?php echo esc_html($vp['subtitle']); ?>)</div>
						</div>
						<div class="org-root-items">
							<?php foreach($vp['subordinates'] as $sub): ?>
								<div class="org-root-item" style="border-color:#bbf7d0" data-search-text="<?php echo esc_attr(strtolower($sub['name'])); ?>">
									<?php echo esc_html($sub['name']); ?>-<?php echo sprintf('%02d', $sub['count']); ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<div class="org-tree-lines">
					<div class="org-line-horizontal"></div>
					<div class="org-arrow-to-admin"></div>
					<div class="org-arrow-to-academic"></div>
				</div>

				<!-- Secondary Categories Row -->
				<div class="org-categories-row">
					<?php foreach($data['categories'] as $cat): ?>
						<?php 
						$is_admin = strpos(strtolower($cat['id']), 'admin') !== false;
						$cat_total = isset($totals[$cat['id']]) ? $totals[$cat['id']]['total'] : 0;
						?>
						<div class="org-category-wrap" id="cat-card-<?php echo esc_attr($cat['id']); ?>" data-category="<?php echo $is_admin ? 'admin' : 'academic'; ?>">
							<div class="org-category-title <?php echo $is_admin ? 'bg-theme-blue' : 'bg-theme-green'; ?>">
								<?php echo esc_html($cat['name']); ?>
							</div>

							<?php if ( ! empty( $cat['subCategories'] ) ): ?>
								<!-- Rendering Sub-categories (For Academics) -->
								<div class="org-subcategories-row">
									<?php foreach($cat['subCategories'] as $sub): ?>
										<?php 
										$sub_is_pre = strpos(strtolower($sub['id']), 'pre') !== false;
										$sub_theme_class = $sub_is_pre ? 'text-theme-greenName' : 'text-theme-yellow';
										$sub_total = isset($totals[$sub['id']]) ? $totals[$sub['id']]['total'] : 0;
										?>
										<div class="org-subcategory">
											<div class="org-subcategory-title <?php echo $sub_is_pre ? 'text-theme-green' : 'text-theme-yellow'; ?>">
												<?php echo esc_html($sub['name']); ?>
											</div>

											<!-- Department grid -->
											<div class="org-departments-grid <?php echo $sub_is_pre ? 'org-dept-preclinical' : 'org-dept-clinical'; ?>">
												<?php foreach($sub['departments'] as $dept): ?>
													<?php 
													$dept_total = isset($totals[$dept['id']]) ? $totals[$dept['id']]['total'] : 0;
													?>
													<div class="org-dept-card clickable-dept-card" id="dept-card-<?php echo esc_attr($dept['id']); ?>" data-dept-id="<?php echo esc_attr($dept['id']); ?>" onclick="openOrgModal(this, '<?php echo $sub_is_pre ? 'dept-bg-green' : 'dept-bg-yellow'; ?>')">
														<div class="org-dept-header <?php echo $sub_is_pre ? 'dept-bg-green' : 'dept-bg-yellow'; ?>">
															<span><?php echo esc_html($dept['code']); ?> <?php echo esc_html($dept['name']); ?></span>
															<span class="org-dept-header-count"><?php echo sprintf('%02d', $dept_total); ?></span>
														</div>
														<ul class="org-dept-list">
															<?php foreach($dept['items'] as $item): ?>
																<?php if (strpos($item['name'], '[SEPARATOR]') === 0): ?>
																	<li class="org-dept-item-separator">
																		<?php echo esc_html(str_replace('[SEPARATOR] ', '', $item['name'])); ?> - <?php echo sprintf('%02d', $item['count']); ?>
																	</li>
																<?php else: ?>
																	<li class="org-dept-item" data-search-text="<?php echo esc_attr(strtolower($item['name'])); ?>">
																		<span>• <?php echo esc_html($item['name']); ?></span>
																		<span style="font-weight:bold"><?php echo sprintf('%02d', $item['count']); ?></span>
																	</li>
																<?php endif; ?>
															<?php endforeach; ?>
														</ul>
													</div>
												<?php endforeach; ?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>

							<?php else: ?>
								<!-- Direct Departments (For Admin) -->
								<div class="org-departments-grid org-dept-admin">
									<?php foreach($cat['departments'] as $dept): ?>
										<?php 
										$dept_total = isset($totals[$dept['id']]) ? $totals[$dept['id']]['total'] : 0;
										?>
										<div class="org-dept-card" id="dept-card-<?php echo esc_attr($dept['id']); ?>" data-dept-id="<?php echo esc_attr($dept['id']); ?>">
											<div class="org-dept-header dept-bg-blue">
												<span><?php echo esc_html($dept['code']); ?> <?php echo esc_html($dept['name']); ?></span>
												<span class="org-dept-header-count"><?php echo sprintf('%02d', $dept_total); ?></span>
											</div>
											<ul class="org-dept-list">
												<?php foreach($dept['items'] as $item): ?>
													<?php if (strpos($item['name'], '[SEPARATOR]') === 0): ?>
														<li class="org-dept-item-separator">
															<?php echo esc_html(str_replace('[SEPARATOR] ', '', $item['name'])); ?> - <?php echo sprintf('%02d', $item['count']); ?>
														</li>
													<?php else: ?>
														<li class="org-dept-item" data-search-text="<?php echo esc_attr(strtolower($item['name'])); ?>">
															<span>• <?php echo esc_html($item['name']); ?></span>
															<span style="font-weight:bold"><?php echo sprintf('%02d', $item['count']); ?></span>
														</li>
													<?php endif; ?>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Footers -->
			<div style="display:flex; justify-content:space-between; flex-wrap:wrap; align-items:flex-start; gap:20px;">
				<div class="org-summary-box">
					<div class="org-summary-title">Summary</div>
					<div class="org-summary-row">
						<span><span style="color:#1e3a8a">●</span> Administration Total:</span>
						<span style="font-weight:bold"><?php echo esc_html($totals['administration']['total']); ?></span>
					</div>
					<div class="org-summary-row">
						<span><span style="color:#047857">●</span> Academic (Pre-Clinical) Total:</span>
						<span style="font-weight:bold"><?php echo esc_html($totals['pre_clinical']['total']); ?></span>
					</div>
					<div class="org-summary-row">
						<span><span style="color:#b45309">●</span> Academic (Clinical) Total:</span>
						<span style="font-weight:bold"><?php echo esc_html($totals['clinical']['total']); ?></span>
					</div>
					<div class="org-summary-row org-summary-total">
						<span>Grand Total:</span>
						<span><?php echo esc_html($totals['grand_total']); ?></span>
					</div>
				</div>

				<?php if ( ! empty( $data['summaryNote'] ) ): ?>
					<div class="org-note-box">
						<strong>NOTE:</strong><br>
						<?php echo esc_html($data['summaryNote']); ?>
					</div>
				<?php endif; ?>
			</div>

			<!-- Inspection Modal Popup -->
			<div class="org-modal-overlay" id="org-inspect-modal" onclick="closeOrgModal(event)">
				<div class="org-modal-content">
					<button type="button" class="org-modal-close" onclick="closeOrgModal(event, true)">✕</button>
					<div class="org-modal-header" id="org-modal-header-container"></div>
					<div class="org-modal-body">
						<ul class="org-modal-list" id="org-modal-list-container"></ul>
					</div>
				</div>
			</div>
		</div>

		<!-- Filter interactive logic -->
		<script>
			function orgFilterCategory(btn, cat) {
				const container = document.getElementById('org-board-college-medical-organigram-chart');
				if (container) {
					container.classList.remove('filter-all', 'filter-admin', 'filter-academic');
					container.classList.add('filter-' + cat);
				}

				const btns = document.querySelectorAll('#org-board-college-medical-organigram-chart .org-filter-btn');
				btns.forEach(b => b.classList.remove('active'));
				if (btn) btn.classList.add('active');

				const wraps = document.querySelectorAll('#org-board-college-medical-organigram-chart .org-category-wrap');
				const roots = document.getElementById('org-roots-section');

				if (cat === 'all') {
					wraps.forEach(w => w.style.display = 'block');
					roots.style.display = 'flex';
				} else if (cat === 'admin') {
					wraps.forEach(w => {
						const is_admin = w.getAttribute('data-category') === 'admin';
						w.style.display = is_admin ? 'block' : 'none';
					});
					roots.style.display = 'flex';
				} else if (cat === 'academic') {
					wraps.forEach(w => {
						const is_academic = w.getAttribute('data-category') === 'academic';
						w.style.display = is_academic ? 'block' : 'none';
					});
					roots.style.display = 'none'; // Academic only focus
				}
			}

			function openOrgModal(card, headerBgClass) {
				const header = card.querySelector('.org-dept-header');
				const listItems = card.querySelectorAll('.org-dept-list li');
				
				const titleText = header.querySelector('span:first-child').textContent;
				const countText = header.querySelector('.org-dept-header-count').textContent;

				const headerContainer = document.getElementById('org-modal-header-container');
				headerContainer.className = 'org-modal-header ' + headerBgClass;
				headerContainer.innerHTML = `<span>${titleText}</span><span class="org-modal-header-count">${countText}</span>`;

				const listContainer = document.getElementById('org-modal-list-container');
				listContainer.innerHTML = '';

				listItems.forEach(item => {
					const cloned = document.createElement('li');
					if (item.classList.contains('org-dept-item-separator')) {
						cloned.className = 'org-modal-list-item-separator';
						cloned.textContent = item.textContent.trim();
					} else {
						cloned.className = 'org-modal-list-item';
						const spanTitle = item.querySelector('span:first-child').textContent;
						const spanCount = item.querySelector('span:last-child').textContent;
						cloned.innerHTML = `<span>${spanTitle}</span><span style="font-weight:bold">${spanCount}</span>`;
					}
					listContainer.appendChild(cloned);
				});

				const modal = document.getElementById('org-inspect-modal');
				modal.style.display = 'flex';
				setTimeout(() => {
					modal.classList.add('active');
				}, 10);
			}

			function closeOrgModal(event, forceClose = false) {
				const modal = document.getElementById('org-inspect-modal');
				if (forceClose || event.target === modal) {
					modal.classList.remove('active');
					setTimeout(() => {
						modal.style.display = 'none';
					}, 250);
				}
			}
		</script>
		<?php
		return ob_get_clean();
	}

	/**
	 * Helper recursive math calculations for sums
	 */
	private function calculate_totals( $data ) {
		$totals = array();
		$grand_total = 0;

		// Calculate Root Node count
		if ( isset( $data['rootNodes'] ) ) {
			foreach( $data['rootNodes'] as $key => $node ) {
				$sub_count = 0;
				if ( ! empty( $node['subordinates'] ) ) {
					foreach( $node['subordinates'] as $sub ) {
						$sub_count += intval( $sub['count'] );
					}
				}
				$totals[$key] = array( 'total' => $sub_count );
			}
		}

		// Process Categories
		if ( isset( $data['categories'] ) ) {
			foreach ( $data['categories'] as $cat ) {
				$cat_total = 0;

				if ( ! empty( $cat['subCategories'] ) ) {
					// Cat has subcats (Academic)
					foreach ( $cat['subCategories'] as $sub ) {
						$sub_total = 0;
						foreach ( $sub['departments'] as $dept ) {
							$dept_total = 0;
							foreach ( $dept['items'] as $item ) {
								// Ignore duplicates or specific headers in counts
								if ( strpos($item['name'], '[SEPARATOR]') !== 0 ) {
									$dept_total += intval( $item['count'] );
								}
							}
							$sub_total += $dept_total;
							$totals[$dept['id']] = array( 'total' => $dept_total );
						}
						total_add:
						$totals[$sub['id']] = array( 'total' => $sub_total );
						$cat_total += $sub_total;
					}
				} else if ( ! empty( $cat['departments'] ) ) {
					// Cat has direct depts (Admin)
					foreach ( $cat['departments'] as $dept ) {
						$dept_total = 0;
						foreach ( $dept['items'] as $item ) {
							if ( strpos($item['name'], '[SEPARATOR]') !== 0 ) {
								$dept_total += intval( $item['count'] );
							}
						}
						$cat_total += $dept_total;
						$totals[$dept['id']] = array( 'total' => $dept_total );
					}
				}

				// Administration offset exception to match exact image totals (if security services are counted differently)
				if ($cat['id'] === 'administration') {
					// In the original spreadsheet/image, Secretary (57) + Accounts (6) + Library (5) + Hostel (47) + Security (25) = 140
					// If they want to force 135 for Administration total, we let it be whatever the sum resolves to, 
					// but we can offer customizable totals!
				}

				$totals[$cat['id']] = array( 'total' => $cat_total );
				$grand_total += $cat_total;
			}
		}

		$totals['grand_total'] = $grand_total;
		return $totals;
	}

	/**
	 * WP-Admin Options Page Renderer
	 */
	public function render_admin_options_page() {
		// Handle settings save
		if ( isset( $_POST['submit_organigram'] ) && check_admin_referer( 'college-medical-organigram-chart_nonce_action', 'college-medical-organigram-chart_nonce' ) ) {
			$raw_json = isset( $_POST['organigram_json'] ) ? wp_unslash( $_POST['organigram_json'] ) : '';
			$custom_css = isset( $_POST['custom_css'] ) ? sanitize_textarea_field( wp_unslash( $_POST['custom_css'] ) ) : '';
			
			// Decode to validate JSON first
			$is_ok = false;
			if ( ! empty( $raw_json ) ) {
				$test = json_decode( $raw_json, true );
				if ( is_array( $test ) ) {
					update_option( 'college-medical-organigram-chart_data', $raw_json );
					$is_ok = true;
				}
			}
			
			update_option( 'college-medical-organigram-chart_custom_css', $custom_css );
			
			$message_class = $is_ok ? 'updated' : 'error';
			$message_text = $is_ok ? 'Organigram updated successfully.' : 'Error: Invalid JSON format. Settings not saved.';
			echo "<div class='Notice notice $message_class is-dismissible'><p>$message_text</p></div>";
		}

		$data_json = wp_json_encode( $this->get_organigram_data(), JSON_PRETTY_PRINT );
		$custom_css = get_option( 'college-medical-organigram-chart_custom_css', '' );
		?>
		<!-- Inject Tailwind CSS into WP Admin to match the preview style perfectly -->
		<script src="https://cdn.tailwindcss.com"></script>
		<style>
			#wpcontent { background: #f8fafc !important; }
			#college-medical-organigram-chart-admin-root input, #college-medical-organigram-chart-admin-root textarea { max-width: 100% !important; }
			.tab-content.hidden { display: none !important; }
		</style>
		<div class="wrap pr-4" id="college-medical-organigram-chart-admin-root" style="font-family:'Inter', sans-serif;">
			<div class="bg-slate-900 text-white rounded-2xl p-6 shadow-md mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
				<div>
					<div class="flex items-center gap-2">
						<span class="text-2xl">🏫</span>
						<h2 class="text-xl font-black text-white m-0">WordPress College Organigram Settings Hub</h2>
					</div>
					<p class="text-xs text-slate-300 mt-1">Manage sections, nested columns, leadership roles, and cards visually without editing any RAW JSON data.</p>
				</div>
				<span class="bg-slate-800 border border-slate-700 text-indigo-300 text-xs px-3 py-1.5 rounded-lg font-mono font-bold select-all">[college_organigram]</span>
			</div>

			<div class="flex gap-1 border-b border-slate-200 mb-6" id="builder-tab-nav">
				<button type="button" class="tab-btn py-2 px-4 font-bold text-sm text-indigo-600 border-b-2 border-indigo-600 focus:outline-none cursor-pointer" onclick="switchTab(this, 'visual')">✨ Visual Tree Editor</button>
				<button type="button" class="tab-btn py-2 px-4 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-800 focus:outline-none cursor-pointer" onclick="switchTab(this, 'expert')">⚙️ Advanced RAW JSON & Override CSS</button>
			</div>

			<form method="post" action="" id="organigram-save-form" class="space-y-6">
				<?php wp_nonce_field( 'college-medical-organigram-chart_nonce_action', 'college-medical-organigram-chart_nonce' ); ?>
				<textarea id="organigram_json" name="organigram_json" style="display:none;"><?php echo esc_textarea( $data_json ); ?></textarea>

				<div id="tab-visual" class="tab-content grid grid-cols-1 xl:grid-cols-12 gap-6">
					<div class="xl:col-span-7 space-y-6">
						<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
							<div class="bg-slate-50 px-5 py-3 border-b border-slate-200"><h3 class="font-bold text-sm text-slate-800 m-0">📝 General Settings</h3></div>
							<div class="p-5 space-y-4">
								<div>
									<label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Organigram Title</label>
									<input type="text" id="cfg-title" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white font-bold" oninput="updateFromForm()">
								</div>
								<div>
									<label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Summary Footer Note</label>
									<textarea id="cfg-note" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white" rows="2" oninput="updateFromForm()"></textarea>
								</div>
							</div>
						</div>

						<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
							<div class="bg-slate-50 px-5 py-3 border-b border-slate-200"><h3 class="font-bold text-sm text-slate-800 m-0">👑 Executive Leaders (Top Tier)</h3></div>
							<div class="p-5 space-y-4" id="root-nodes-editor"></div>
						</div>

						<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
							<div class="bg-slate-50 px-5 py-3 border-b border-slate-200 flex justify-between items-center flex-wrap gap-2">
								<div>
									<h3 class="font-bold text-sm text-slate-800 m-0">🗄️ Organization Columns & Sections</h3>
									<p class="text-[11px] text-slate-400 mt-0.5">Define category grids and nested branch cells.</p>
								</div>
								<button type="button" onclick="addNewCategory()" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs px-3 py-1.5 rounded-lg cursor-pointer">➕ Add Column</button>
							</div>
							<div class="p-5 space-y-6 divide-y divide-slate-100" id="categories-editor"></div>
						</div>
					</div>

					<div class="xl:col-span-12">
						<div class="space-y-4">
							<div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
								<div class="bg-slate-900 text-white px-5 py-3 flex justify-between items-center">
									<div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span><span class="font-bold text-xs text-white">Live Updating Sandbox Preview Overlay</span></div>
								</div>
								<div class="p-4 bg-slate-100 overflow-auto max-h-[850px]" id="wp-live-preview-box"></div>
							</div>

							<div class="bg-slate-100 rounded-xl p-4 border border-slate-200 flex flex-col gap-2">
								<p class="text-[11px] text-slate-500 m-0">Lock your changes secure and save them directly deep into the database:</p>
								<div class="flex gap-2">
									<input type="submit" name="submit_organigram" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 px-4 rounded-lg text-xs uppercase tracking-wider cursor-pointer transition shadow hover:scale-[1.01]" value="💾 Save Config">
									<button type="button" onclick="resetToInitialDefaults()" class="bg-white hover:bg-slate-100 border border-slate-300 text-slate-700 font-bold px-3 py-2 rounded-lg text-xs cursor-pointer">Reset Defaults</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="tab-expert" class="tab-content hidden space-y-6">
					<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
						<div class="p-5 space-y-4">
							<div>
								<label class="block text-xs font-bold text-slate-500 mb-1">Backup / Raw JSON Data</label>
								<textarea id="raw-json-editor" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs font-mono bg-white" rows="12" oninput="syncFromRawJson()"></textarea>
							</div>
							<div>
								<label class="block text-xs font-bold text-slate-500 mb-1">Custom Styling Overrides (CSS)</label>
								<textarea name="custom_css" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs font-mono bg-white" rows="4"><?php echo esc_textarea( $custom_css ); ?></textarea>
							</div>
						</div>
						<div class="bg-slate-50 px-5 py-3 border-t border-slate-100 flex justify-end">
							<input type="submit" name="submit_organigram" class="bg-indigo-600 hover:bg-slate-900 text-white font-bold py-2 px-4 rounded-lg text-xs cursor-pointer" value="Save Advanced Configuration">
						</div>
					</div>
				</div>
			</form>
		</div>

		<script>
		(function() {
			var data = null;
			var defaultData = null;

			var jsonTextarea = document.getElementById('organigram_json');
			var rawTextarea = document.getElementById('raw-json-editor');

			function init() {
				try {
					data = JSON.parse(jsonTextarea.value || '{}');
					defaultData = JSON.parse(JSON.stringify(data));
				} catch (e) {
					console.error("JSON init error", e);
					data = {};
				}
				if (rawTextarea) rawTextarea.value = JSON.stringify(data, null, 2);
				renderBuilder();
				renderLivePreview();
			}

			window.switchTab = function(btn, tabName) {
				document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
				document.getElementById('tab-' + tabName).classList.remove('hidden');

				var tabs = document.querySelectorAll('#builder-tab-nav button');
				tabs.forEach(t => {
					t.classList.remove('text-indigo-600', 'border-indigo-600');
					t.classList.add('text-slate-500', 'border-transparent');
				});

				if (btn) {
					btn.classList.remove('text-slate-500', 'border-transparent');
					btn.classList.add('text-indigo-600', 'border-indigo-600');
				}
			};

			function renderBuilder() {
				document.getElementById('cfg-title').value = data.title || '';
				document.getElementById('cfg-note').value = data.summaryNote || '';

				var execContainer = document.getElementById('root-nodes-editor');
				execContainer.innerHTML = '';
				if (data.rootNodes) {
					Object.keys(data.rootNodes).forEach(function(key) {
						var node = data.rootNodes[key];
						var card = document.createElement('div');
						card.className = "p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3";
						card.innerHTML = 
							'<div class="grid grid-cols-2 gap-3">' +
							'	<div>' +
							'		<label class="block text-[9px] font-bold text-slate-500 uppercase tracking-widest mb-1">Leader Name</label>' +
							'		<input type="text" id="exec-title-' + key + '" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs font-bold text-slate-800 bg-white" value="' + escapeHtml(node.name) + '" oninput="updateExecutiveNode(\'' + key + '\')">' +
							'	</div>' +
							'	<div>' +
							'		<label class="block text-[9px] font-bold text-slate-500 uppercase tracking-widest mb-1">Subtitle Role</label>' +
							'		<input type="text" id="exec-sub-' + key + '" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs text-slate-600 bg-white" value="' + escapeHtml(node.subtitle) + '" oninput="updateExecutiveNode(\'' + key + '\')">' +
							'	</div>' +
							'</div>' +
							'<div class="space-y-2">' +
							'	<div class="flex justify-between items-center">' +
							'		<span class="text-[9px] font-bold text-slate-500 uppercase tracking-wide">Direct Assistants / Staff:</span>' +
							'		<button type="button" onclick="addExecSubordinate(\'' + key + '\')" class="text-[9px] bg-indigo-50 text-indigo-700 px-2 py-0.5 border border-indigo-200 rounded font-bold cursor-pointer">➕ Add Role</button>' +
							'	</div>' +
							'	<div id="exec-subordinates-' + key + '" class="space-y-1.5"></div>' +
							'</div>';
						execContainer.appendChild(card);

						var subC = document.getElementById('exec-subordinates-' + key);
						(node.subordinates || []).forEach(function(sub, subIdx) {
							var row = document.createElement('div');
							row.className = "flex gap-2 items-center bg-white p-2 rounded-lg border border-slate-200";
							row.innerHTML = 
								'<input type="text" class="flex-1 px-2 py-1 border border-slate-300 rounded text-xs bg-white text-slate-800" value="' + escapeHtml(sub.name) + '" oninput="updateExecSubordinateField(\'' + key + '\', ' + subIdx + ', \'name\', this.value)">' +
								'<input type="number" class="w-16 px-2 py-1 border border-slate-300 rounded text-xs text-center bg-white text-slate-800" value="' + sub.count + '" oninput="updateExecSubordinateField(\'' + key + '\', ' + subIdx + ', \'count\', this.value)">' +
								'<button type="button" onclick="deleteExecSubordinate(\'' + key + '\', ' + subIdx + ')" class="text-[10px] text-red-500 cursor-pointer">✕</button>';
							subC.appendChild(row);
						});
					});
				}

				var columnsContainer = document.getElementById('categories-editor');
				columnsContainer.innerHTML = '';
				(data.categories || []).forEach(function(cat, catIdx) {
					var catDiv = document.createElement('div');
					catDiv.className = "py-4 border-b border-slate-100";
					var hasSubcats = Array.isArray(cat.subCategories) && cat.subCategories.length > 0;

					var nestedPillarsButton = !hasSubcats ? '<button type="button" onclick="splitIntoSubcategoryLayout(' + catIdx + ')" class="text-[9px] bg-amber-50 text-amber-750 px-2 py-1 rounded font-bold cursor-pointer">Nested Pillars</button>' : '';
					catDiv.innerHTML = 
						'<div class="flex justify-between items-center gap-3 mb-3">' +
						'	<div class="flex-1">' +
						'		<label class="block text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-1">COLUMN CATEGORY SECTION</label>' +
						'		<input type="text" class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-sm bg-white font-bold text-slate-800" value="' + escapeHtml(cat.name) + '" oninput="updateCategoryName(' + catIdx + ', this.value)">' +
						'	</div>' +
						'	<div class="flex gap-1">' +
						'		<button type="button" onclick="moveCategory(' + catIdx + ', -1)" class="px-2 py-1 border border-slate-200 bg-white hover:bg-slate-50 text-[10px] cursor-pointer">▲</button>' +
						'		<button type="button" onclick="moveCategory(' + catIdx + ', 1)" class="px-2 py-1 border border-slate-200 bg-white hover:bg-slate-50 text-[10px] cursor-pointer">▼</button>' +
						'		<button type="button" onclick="deleteCategory(' + catIdx + ')" class="px-2 py-1 bg-red-50 text-red-500 rounded text-xs cursor-pointer">🗑️ Delete</button>' +
						'	</div>' +
						'</div>' +
						'<div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-4">' +
						'	<div class="flex justify-between items-center">' +
						'		<span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">Branch Nodes & Cards:</span>' +
						'		<div class="flex gap-2">' +
						'			' + nestedPillarsButton +
						'			<button type="button" onclick="addDeptToCat(' + catIdx + ')" class="text-[9px] bg-indigo-600 text-white px-2 py-1 rounded cursor-pointer font-bold">➕ Add Branch Card</button>' +
						'		</div>' +
						'	</div>' +
						'	<div class="space-y-3" id="cat-nested-nodes-' + catIdx + '"></div>' +
						'</div>';

					columnsContainer.appendChild(catDiv);
					var nestedC = document.getElementById('cat-nested-nodes-' + catIdx);

					if (hasSubcats) {
						cat.subCategories.forEach(function(sub, subIdx) {
							var subBox = document.createElement('div');
							subBox.className = "bg-white border border-slate-150 rounded-xl p-3 space-y-3";
							subBox.innerHTML = 
								'<div class="flex justify-between items-center pb-2 border-b border-slate-100 gap-4">' +
								'	<input type="text" class="flex-1 px-2 py-1 border border-slate-200 rounded text-xs font-black bg-white" value="' + escapeHtml(sub.name) + '" oninput="updateSubCategoryName(' + catIdx + ', ' + subIdx + ', this.value)">' +
								'	<div class="flex gap-1">' +
								'		<button type="button" onclick="addDeptToSubCategory(' + catIdx + ', ' + subIdx + ')" class="bg-indigo-50 text-indigo-700 text-[10px] px-2 py-0.5 rounded cursor-pointer font-extrabold">➕ Dept</button>' +
								'		<button type="button" onclick="deleteSubCategory(' + catIdx + ', ' + subIdx + ')" class="text-xs text-red-500 cursor-pointer">✕</button>' +
								'	</div>' +
								'</div>' +
								'<div class="space-y-3" id="sub-depts-' + catIdx + '-' + subIdx + '"></div>';
							nestedC.appendChild(subBox);
							var subDeptC = document.getElementById('sub-depts-' + catIdx + '-' + subIdx);
							(sub.departments || []).forEach(function(dept, deptIdx) {
								subDeptC.appendChild(createDepartmentFormDom(catIdx, subIdx, dept, deptIdx));
							});
						});
					} else {
						(cat.departments || []).forEach(function(dept, deptIdx) {
							nestedC.appendChild(createDepartmentFormDom(catIdx, null, dept, deptIdx));
						});
					}
				});
			}

			function createDepartmentFormDom(catIdx, subIdx, dept, deptIdx) {
				var div = document.createElement('div');
				div.className = "p-3 bg-white border border-slate-200 rounded-lg space-y-3";
				var isSub = subIdx !== null;
				var subParam = isSub ? subIdx : 'null';

				div.innerHTML = 
					'<div class="flex justify-between items-center border-b border-slate-100 pb-2">' +
					'	<div class="flex-1 grid grid-cols-4 gap-2">' +
					'		<input type="text" class="col-span-1 px-2 py-1 border border-slate-300 rounded text-xs font-bold bg-white text-center" value="' + escapeHtml(dept.code || '') + '" placeholder="CODE" oninput="updateDeptString(' + catIdx + ', ' + subParam + ', ' + deptIdx + ', \'code\', this.value.toUpperCase())">' +
					'		<input type="text" class="col-span-3 px-2 py-1 border border-slate-300 rounded text-xs font-bold bg-white" value="' + escapeHtml(dept.name) + '" placeholder="Dept Title" oninput="updateDeptString(' + catIdx + ', ' + subParam + ', ' + deptIdx + ', \'name\', this.value)">' +
					'	</div>' +
					'	<div class="flex gap-1 ml-2">' +
					'		<button type="button" onclick="moveDept(' + catIdx + ', ' + subParam + ', ' + deptIdx + ', -1)" class="p-1 border border-slate-200 bg-white hover:bg-slate-50 rounded text-xs cursor-pointer">▲</button>' +
					'		<button type="button" onclick="moveDept(' + catIdx + ', ' + subParam + ', ' + deptIdx + ', 1)" class="p-1 border border-slate-200 bg-white hover:bg-slate-50 rounded text-xs cursor-pointer">▼</button>' +
					'		<button type="button" onclick="deleteDept(' + catIdx + ', ' + subParam + ', ' + deptIdx + ')" class="p-1 text-red-500 cursor-pointer">✕</button>' +
					'	</div>' +
					'</div>' +
					'<div class="space-y-1.5">' +
					'	<div class="flex justify-between items-center">' +
					'		<span class="text-[8.5px] font-bold text-slate-400">Personnel Breakdown Roles:</span>' +
					'		<button type="button" onclick="addDeptDetailRow(' + catIdx + ', ' + subParam + ', ' + deptIdx + ')" class="text-[9px] bg-indigo-50 border border-indigo-200 text-indigo-700 px-2 py-0.5 rounded font-bold cursor-pointer">➕ Add Row</button>' +
					'	</div>' +
					'	<div class="space-y-1.5" id="dept-det-list-' + catIdx + '-' + (isSub ? subIdx : 'no') + '-' + deptIdx + '"></div>' +
					'</div>';

				setTimeout(function() {
					var el = document.getElementById('dept-det-list-' + catIdx + '-' + (isSub ? subIdx : 'no') + '-' + deptIdx);
					if (!el) return;
					(dept.items || []).forEach(function(item, itemIdx) {
						var isSep = (item.name || '').startsWith('[SEPARATOR] ');
						var rawName = isSep ? item.name.replace('[SEPARATOR] ', '') : item.name;
						var checkedAttr = isSep ? 'checked' : '';
						var row = document.createElement('div');
						row.className = "flex gap-2 items-center bg-slate-50 p-2 rounded border border-slate-200";
						row.innerHTML = 
							'<div class="flex items-center gap-1.5 flex-1 min-w-0">' +
							'	<input type="checkbox" id="hdr-chk-' + catIdx + '-' + (isSub ? subIdx : 'no') + '-' + deptIdx + '-' + itemIdx + '" ' + checkedAttr + ' class="cursor-pointer" onchange="toggleItemIsHeading(' + catIdx + ', ' + subParam + ', ' + deptIdx + ', ' + itemIdx + ', this.checked)">' +
							'	<label for="hdr-chk-' + catIdx + '-' + (isSub ? subIdx : 'no') + '-' + deptIdx + '-' + itemIdx + '" class="text-[8.5px] font-mono text-slate-400 select-none cursor-pointer">Banner</label>' +
							'	<input type="text" class="flex-1 px-2 py-0.5 border border-slate-300 rounded text-xs bg-white text-slate-800" value="' + escapeHtml(rawName) + '" oninput="updateDeptItemString(' + catIdx + ', ' + subParam + ', ' + deptIdx + ', ' + itemIdx + ', \'name\', this.value)">' +
							'</div>' +
							'<input type="number" class="w-14 px-1 py-0.5 border border-slate-300 rounded text-xs text-center bg-white text-slate-800 font-bold" value="' + (item.count || 0) + '" oninput="updateDeptItemString(' + catIdx + ', ' + subParam + ', ' + deptIdx + ', ' + itemIdx + ', \'count\', this.value)">' +
							'<button type="button" onclick="deleteDeptRow(' + catIdx + ', ' + subParam + ', ' + deptIdx + ', ' + itemIdx + ')" class="text-red-500 text-[10px] font-bold cursor-pointer">✕</button>';
						el.appendChild(row);
					});
				}, 0);

				return div;
			}

			var onChange = function() {
				var jsonStr = JSON.stringify(data, null, 2);
				jsonTextarea.value = jsonStr;
				if (rawTextarea) rawTextarea.value = jsonStr;
				renderLivePreview();
			};

			window.updateFromForm = function() {
				data.title = document.getElementById('cfg-title').value;
				data.summaryNote = document.getElementById('cfg-note').value;
				onChange();
			};

			window.updateExecutiveNode = function(key) {
				if (!data.rootNodes[key]) return;
				data.rootNodes[key].name = document.getElementById('exec-title-' + key).value;
				data.rootNodes[key].subtitle = document.getElementById('exec-sub-' + key).value;
				onChange();
			};

			window.updateExecSubordinateField = function(key, index, field, value) {
				if (!data.rootNodes[key] || !data.rootNodes[key].subordinates[index]) return;
				if (field === 'count') {
					data.rootNodes[key].subordinates[index][field] = parseInt(value) || 0;
				} else {
					data.rootNodes[key].subordinates[index][field] = value;
				}
				onChange();
			};

			window.addExecSubordinate = function(key) {
				if (!data.rootNodes[key]) return;
				if (!Array.isArray(data.rootNodes[key].subordinates)) data.rootNodes[key].subordinates = [];
				data.rootNodes[key].subordinates.push({ name: 'New Role', count: 0 });
				onChange();
				renderBuilder();
			};

			window.deleteExecSubordinate = function(key, index) {
				if (!data.rootNodes[key] || !data.rootNodes[key].subordinates) return;
				data.rootNodes[key].subordinates.splice(index, 1);
				onChange();
				renderBuilder();
			};

			window.addNewCategory = function() {
				data.categories.push({ id: 'cat_' + Date.now(), name: 'New Section Pillar', departments: [] });
				onChange();
				renderBuilder();
			};

			window.updateCategoryName = function(catIdx, value) {
				if (data.categories[catIdx]) { data.categories[catIdx].name = value; onChange(); }
			};

			window.deleteCategory = function(catIdx) {
				if (confirm('Delete Column section?')) { data.categories.splice(catIdx, 1); onChange(); renderBuilder(); }
			};

			window.moveCategory = function(catIdx, dir) {
				var list = data.categories;
				var target = catIdx + dir;
				if (target >= 0 && target < list.length) {
					var temp = list[catIdx];
					list[catIdx] = list[target];
					list[target] = temp;
					onChange();
					renderBuilder();
				}
			};

			window.splitIntoSubcategoryLayout = function(catIdx) {
				var cat = data.categories[catIdx];
				if (!cat) return;
				cat.subCategories = [ { id: 'sub_' + cat.id + '_1', name: 'Division Branch A', departments: cat.departments || [] } ];
				delete cat.departments;
				onChange();
				renderBuilder();
			};

			window.updateSubCategoryName = function(catIdx, subIdx, value) {
				if (data.categories[catIdx] && data.categories[catIdx].subCategories[subIdx]) {
					data.categories[catIdx].subCategories[subIdx].name = value;
					onChange();
				}
			};

			window.deleteSubCategory = function(catIdx, subIdx) {
				data.categories[catIdx].subCategories.splice(subIdx, 1);
				if (data.categories[catIdx].subCategories.length === 0) {
					data.categories[catIdx].departments = [];
					delete data.categories[catIdx].subCategories;
				}
				onChange();
				renderBuilder();
			};

			window.addDeptToSubCategory = function(catIdx, subIdx) {
				var sub = data.categories[catIdx].subCategories[subIdx];
				if (!sub.departments) sub.departments = [];
				sub.departments.push({ id: 'dept_' + Date.now(), code: 'NEW', name: 'New Pillar Card', items: [] });
				onChange();
				renderBuilder();
			};

			window.addDeptToCat = function(catIdx) {
				var cat = data.categories[catIdx];
				if (Array.isArray(cat.subCategories)) {
					if (cat.subCategories.length === 0) {
						cat.subCategories.push({ id: 'sub_' + cat.id + '_1', name: 'Branch 1', departments: [] });
					}
					addDeptToSubCategory(catIdx, 0);
				} else {
					if (!cat.departments) cat.departments = [];
					cat.departments.push({ id: 'dept_' + Date.now(), code: 'NEW', name: 'New Pillar Card', items: [] });
					onChange();
					renderBuilder();
				}
			};

			window.updateDeptString = function(catIdx, subIdx, deptIdx, field, value) {
				var dept = getDept(catIdx, subIdx, deptIdx);
				if (dept) { dept[field] = value; onChange(); }
			};

			window.deleteDept = function(catIdx, subIdx, deptIdx) {
				var list = getDeptList(catIdx, subIdx);
				if (list) { list.splice(deptIdx, 1); onChange(); renderBuilder(); }
			};

			window.moveDept = function(catIdx, subIdx, deptIdx, dir) {
				var list = getDeptList(catIdx, subIdx);
				var target = deptIdx + dir;
				if (list && target >= 0 && target < list.length) {
					var temp = list[deptIdx];
					list[deptIdx] = list[target];
					list[target] = temp;
					onChange();
					renderBuilder();
				}
			};

			window.addDeptDetailRow = function(catIdx, subIdx, deptIdx) {
				var dept = getDept(catIdx, subIdx, deptIdx);
				if (dept) {
					if (!dept.items) dept.items = [];
					dept.items.push({ name: 'New Staff Title', count: 0 });
					onChange();
					renderBuilder();
				}
			};

			window.deleteDeptRow = function(catIdx, subIdx, deptIdx, itemIdx) {
				var dept = getDept(catIdx, subIdx, deptIdx);
				if (dept && dept.items) { dept.items.splice(itemIdx, 1); onChange(); renderBuilder(); }
			};

			window.toggleItemIsHeading = function(catIdx, subIdx, deptIdx, itemIdx, checked) {
				var dept = getDept(catIdx, subIdx, deptIdx);
				if (dept && dept.items && dept.items[itemIdx]) {
					var item = dept.items[itemIdx];
					var isSep = item.name.startsWith('[SEPARATOR] ');
					if (checked && !isSep) item.name = '[SEPARATOR] ' + item.name;
					else if (!checked && isSep) item.name = item.name.replace('[SEPARATOR] ', '');
					onChange();
					renderBuilder();
				}
			};

			window.updateDeptItemString = function(catIdx, subIdx, deptIdx, itemIdx, field, value) {
				var dept = getDept(catIdx, subIdx, deptIdx);
				if (dept && dept.items && dept.items[itemIdx]) {
					var item = dept.items[itemIdx];
					if (field === 'count') {
						item[field] = parseInt(value) || 0;
					} else {
						var isSep = item.name.startsWith('[SEPARATOR] ');
						item.name = isSep ? '[SEPARATOR] ' + value.replace('[SEPARATOR] ', '') : value;
					}
					onChange();
				}
			};

			function getDeptList(catIdx, subIdx) {
				var cat = data.categories[catIdx];
				if (!cat) return null;
				return subIdx !== null ? (cat.subCategories[subIdx] ? cat.subCategories[subIdx].departments : null) : cat.departments;
			}

			function getDept(catIdx, subIdx, deptIdx) {
				var list = getDeptList(catIdx, subIdx);
				return list ? list[deptIdx] : null;
			}

			function escapeHtml(text) {
				var map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
				return (text || '').toString().replace(/[&<>"']/g, function(m) { return map[m]; });
			}

			function renderLivePreview() {
				var container = document.getElementById('wp-live-preview-box');
				if (!container) return;

				var totals = calculateTotalsData(data);
				var html = '';
				html += '<style>';
				html += ' .p-box-w { display: flex; flex-direction: column; gap:14px; font-family:"Inter", sans-serif; background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px; color:#1e293b; }';
				html += ' .p-leaders { display:flex; gap:12px; justify-content:center; margin-bottom:12px; }';
				html += ' .p-lcard { background:#fff; border:2px solid #0f172a; border-radius:8px; width:145px; text-align:center; overflow:hidden; }';
				html += ' .p-lhead { background:#0f172a; color:#fff; font-size:10px; font-weight:bold; padding:4px; }';
				html += ' .p-lsub { font-size:8px; font-weight:normal; opacity:0.8; margin-top:2px; }';
				html += ' .p-lbody { padding:4px; display:flex; flex-direction:column; gap:2.5px; background:#fafafa; font-size:8px; }';
				html += ' .p-conn-line { height: 2px; background: #cbd5e1; margin: 12px 0; position: relative; }';
				html += ' .p-conn-line::after { content:""; position:absolute; left:50%; top:-8px; bottom:-8px; border-left:1.5px dashed #94a3b8; }';
				html += ' .p-cols { display:grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap:12px; }';
				html += ' .p-col-sec { border:1px solid #e2e8f0; border-radius:8px; background:#fff; padding:8px; }';
				html += ' .p-col-title { font-size:10px; font-weight:bold; text-align:center; background:#1e3a8a; color:#fff; padding:4px; border-radius:4px; margin-bottom:8px; text-transform:uppercase; }';
				html += ' .p-card-dept { border:1px solid #cbd5e1; border-radius:6px; overflow:hidden; background:#fff; margin-bottom:8px; }';
				html += ' .p-dept-h { background:#1e3a8a; color:#fff; font-size:9px; font-weight:bold; padding:3.5px 6px; display:flex; justify-content:space-between; }';
				html += ' .p-dept-b { padding:3px; margin:0; list-style:none; }';
				html += ' .p-dept-r { display:flex; justify-content:space-between; font-size:8.5px; padding:2px 4px; border-bottom:1px solid #f8fafc; }';
				html += ' .p-dept-sep { font-weight:bold; background:#f1f5f9; text-align:center; font-size:8px; padding:2.5px; color:#475569; }';
				html += ' .p-sumNote { border-left:3px solid #6366f1; background:#f5f3ff; color:#4f46e5; padding:6px; border-radius:4px; font-size:9px; }';
				html += '</style>';

				html += '<div class="p-box-w">';
				html += '<div class="text-xs font-bold text-slate-800 border-b border-slate-150 pb-1 mb-2 uppercase">' + escapeHtml(data.title || 'Live Organigram Layout') + '</div>';

				html += '<div class="p-leaders">';
				if (data.rootNodes) {
					Object.keys(data.rootNodes).forEach(function(key) {
						var node = data.rootNodes[key];
						html += '<div class="p-lcard">';
						html += '<div class="p-lhead">' + escapeHtml(node.name) + '<div class="p-lsub">' + escapeHtml(node.subtitle) + '</div></div>';
						html += '<div class="p-lbody">';
						(node.subordinates || []).forEach(function(sub) {
							html += '<div>• ' + escapeHtml(sub.name) + ' (' + sub.count + ')</div>';
						});
						html += '</div></div>';
					});
				}
				html += '</div>';

				html += '<div class="p-conn-line"></div>';

				html += '<div class="p-cols">';
				(data.categories || []).forEach(function(cat) {
					html += '<div class="p-col-sec">';
					html += '<div class="p-col-title">' + escapeHtml(cat.name) + '</div>';

					if (cat.subCategories && cat.subCategories.length > 0) {
						cat.subCategories.forEach(function(sub) {
							html += '<div class="text-[8px] font-bold text-center text-emerald-700 uppercase bg-emerald-50 py-1 rounded mb-2">' + escapeHtml(sub.name) + '</div>';
							(sub.departments || []).forEach(function(dept) {
								var dt = (totals[dept.id] || {total:0}).total;
								html += '<div class="p-card-dept">';
								html += '<div class="p-dept-h"><span>' + escapeHtml(dept.code) + ' ' + escapeHtml(dept.name) + '</span><span>' + dt + '</span></div>';
								html += '<ul class="p-dept-b">';
								(dept.items || []).forEach(function(item) {
									if (item.name.indexOf('[SEPARATOR] ') === 0) {
										html += '<li class="p-dept-sep">' + escapeHtml(item.name.replace('[SEPARATOR] ', '')) + '</li>';
									} else {
										html += '<li class="p-dept-r"><span>' + escapeHtml(item.name) + '</span><span>' + item.count + '</span></li>';
									}
								});
								html += '</ul></div>';
							});
						});
					} else {
						(cat.departments || []).forEach(function(dept) {
							var dt = (totals[dept.id] || {total:0}).total;
							html += '<div class="p-card-dept">';
							html += '<div class="p-dept-h"><span>' + escapeHtml(dept.code) + ' ' + escapeHtml(dept.name) + '</span><span>' + dt + '</span></div>';
							html += '<ul class="p-dept-b">';
							(dept.items || []).forEach(function(item) {
								if (item.name.indexOf('[SEPARATOR] ') === 0) {
									html += '<li class="p-dept-sep">' + escapeHtml(item.name.replace('[SEPARATOR] ', '')) + '</li>';
								} else {
									html += '<li class="p-dept-r"><span>' + escapeHtml(item.name) + '</span><span>' + item.count + '</span></li>';
								}
							});
							html += '</ul></div>';
						});
					}
					html += '</div>';
				});
				html += '</div>';

				html += '<div class="bg-slate-50 p-3 rounded-lg border border-slate-200 text-[10px] font-bold flex justify-between"><span>Grand Total Dynamic Headcount:</span><span>' + totals.grand_total + ' Staff</span></div>';

				if (data.summaryNote) {
					html += '<div class="p-sumNote"><strong>Note:</strong> ' + escapeHtml(data.summaryNote) + '</div>';
				}

				html += '</div>';
				container.innerHTML = html;
			}

			function calculateTotalsData(d) {
				var totals = {};
				var grand = 0;
				if (d.rootNodes) {
					Object.keys(d.rootNodes).forEach(function(key) {
						var count = 0;
						(d.rootNodes[key].subordinates || []).forEach(function(sub) { count += parseInt(sub.count) || 0; });
						totals[key] = { total: count };
					});
				}
				if (d.categories) {
					d.categories.forEach(function(cat) {
						var catTotal = 0;
						if (cat.subCategories && cat.subCategories.length > 0) {
							cat.subCategories.forEach(function(sub) {
								var subTotal = 0;
								(sub.departments || []).forEach(function(dept) {
									var deptTotal = 0;
									(dept.items || []).forEach(function(item) {
										if (item.name.indexOf('[SEPARATOR] ') !== 0) deptTotal += parseInt(item.count) || 0;
									});
									subTotal += deptTotal;
									totals[dept.id] = { total: deptTotal };
								});
								totals[sub.id] = { total: subTotal };
								catTotal += subTotal;
							});
						} else if (cat.departments) {
							cat.departments.forEach(function(dept) {
								var deptTotal = 0;
								(dept.items || []).forEach(function(item) {
									if (item.name.indexOf('[SEPARATOR] ') !== 0) deptTotal += parseInt(item.count) || 0;
								});
								catTotal += deptTotal;
								totals[dept.id] = { total: deptTotal };
							});
						}
						totals[cat.id] = { total: catTotal };
						grand += catTotal;
					});
				}
				totals.grand_total = grand;
				return totals;
			}

			window.syncFromRawJson = function() {
				try {
					var test = JSON.parse(rawTextarea.value);
					if (test && typeof test === 'object') {
						data = test;
						jsonTextarea.value = rawTextarea.value;
						renderBuilder();
						renderLivePreview();
					}
				} catch (e) {}
			};

			window.resetToInitialDefaults = function() {
				if (confirm('Are you sure you want to reset everything back to the default demo template data?')) {
					data = JSON.parse(JSON.stringify(defaultData));
					onChange();
					renderBuilder();
				}
			};

			document.addEventListener("DOMContentLoaded", init);
		})();
		</script>
		<?php
	}
}

// Instantiate.
new WR_College_Organigram();
