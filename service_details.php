<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = htmlspecialchars($_SESSION['username']);

// Define all service details with genuine Indian government links
$serviceDetails = [
    "aadhaar" => [
        "title" => "Aadhaar Services",
        "description" => "Aadhaar is a 12-digit unique identity number that can be obtained voluntarily by residents of India, based on their biometric and demographic data. The data is collected by the Unique Identification Authority of India (UIDAI), a statutory authority established in January 2009 by the government of India.",
        "icon" => "📋",
        "color" => "from-blue-400 to-blue-600",
        "links" => [
            ["title" => "Official UIDAI Website", "url" => "https://uidai.gov.in/", "icon" => "🏛️"],
            ["title" => "Download e-Aadhaar", "url" => "https://eaadhaar.uidai.gov.in/", "icon" => "📥"],
            ["title" => "Update Aadhaar Details", "url" => "https://ssup.uidai.gov.in/", "icon" => "✏️"],
            ["title" => "Check Aadhaar Status", "url" => "https://resident.uidai.gov.in/check-aadhaar-status", "icon" => "🔍"]
        ]
    ],
    "pan" => [
        "title" => "PAN Card Services",
        "description" => "Permanent Account Number (PAN) is a ten-character alphanumeric identifier, issued in the form of a laminated 'PAN card', by the Indian Income Tax Department. It is mandatory for all tax-paying entities in India.",
        "icon" => "💳",
        "color" => "from-green-400 to-green-600",
        "links" => [
            ["title" => "Apply for PAN Card", "url" => "https://www.incometax.gov.in/iec/foportal/en/pan-card", "icon" => "📝"],
            ["title" => "Track PAN Application", "url" => "https://www.incometax.gov.in/iec/foportal/en/track-pan-application", "icon" => "🔍"],
            ["title" => "Link PAN with Aadhaar", "url" => "https://www.incometax.gov.in/iec/foportal/en/link-pan-aadhaar", "icon" => "🔗"],
            ["title" => "Verify PAN", "url" => "https://www.incometax.gov.in/iec/foportal/en/verify-pan", "icon" => "✅"]
        ]
    ],
    "passport" => [
        "title" => "Passport Services",
        "description" => "Indian passports are issued by the Ministry of External Affairs of the Government of India to Indian citizens for the purpose of international travel. They enable the bearer to travel internationally and serve as proof of Indian citizenship.",
        "icon" => "🛂",
        "color" => "from-purple-400 to-purple-600",
        "links" => [
            ["title" => "Passport Seva Portal", "url" => "https://www.passportindia.gov.in/", "icon" => "🌐"],
            ["title" => "Track Application Status", "url" => "https://www.passportindia.gov.in/AppOnlineProject/statusTracker/track", "icon" => "🔍"],
            ["title" => "Book Appointment", "url" => "https://www.passportindia.gov.in/AppOnlineProject/appointment", "icon" => "📅"],
            ["title" => "Passport Fee Calculator", "url" => "https://www.passportindia.gov.in/AppOnlineProject/feeCalculator", "icon" => "💰"]
        ]
    ],
    "driving" => [
        "title" => "Driving License Services",
        "description" => "A driving licence is an official document permitting a specific individual to operate one or more types of motorized vehicles on public roads. In India, driving licences are issued by the Regional Transport Authority (RTA) or Regional Transport Office (RTO) of respective states.",
        "icon" => "🚗",
        "color" => "from-red-400 to-red-600",
        "links" => [
            ["title" => "Sarathi Portal", "url" => "https://sarathi.parivahan.gov.in/", "icon" => "🌐"],
            ["title" => "Apply for Learner's License", "url" => "https://sarathi.parivahan.gov.in/sarathiservice/stateSelection.do", "icon" => "📝"],
            ["title" => "Apply for Driving License", "url" => "https://sarathi.parivahan.gov.in/sarathiservice/stateSelection.do", "icon" => "🚘"],
            ["title" => "Track Application Status", "url" => "https://sarathi.parivahan.gov.in/sarathiservice/stateSelection.do", "icon" => "🔍"]
        ]
    ],
    "voter" => [
        "title" => "Voter ID Services",
        "description" => "The Voter ID Card, also known as the Electors Photo Identity Card (EPIC), is an identity document issued by the Election Commission of India to adult domiciles of India who have reached the age of 18, which primarily serves as an identity proof for Indian citizens while casting their ballot in the country's municipal, state, and national elections.",
        "icon" => "🗳️",
        "color" => "from-yellow-400 to-yellow-600",
        "links" => [
            ["title" => "National Voters' Service Portal", "url" => "https://www.nvsp.in/", "icon" => "🌐"],
            ["title" => "Apply for Voter ID", "url" => "https://www.nvsp.in/Forms/Forms/form6", "icon" => "📝"],
            ["title" => "Download e-EPIC", "url" => "https://www.nvsp.in/Forms/Forms/epic-download", "icon" => "📥"],
            ["title" => "Search Name in Voter List", "url" => "https://www.nvsp.in/Forms/Forms/searchForm", "icon" => "🔍"]
        ]
    ],
    "certificates" => [
        "title" => "Certificates",
        "description" => "Various certificates are issued by the government for different purposes such as birth, death, income, residence, etc. These certificates are essential for availing various government services and benefits.",
        "icon" => "📜",
        "color" => "from-pink-400 to-pink-600",
        "links" => [
            ["title" => "Birth Certificate", "url" => "https://jansuvidha.gov.in/birth-certificate", "icon" => "👶"],
            ["title" => "Death Certificate", "url" => "https://jansuvidha.gov.in/death-certificate", "icon" => "⚰️"],
            ["title" => "Income Certificate", "url" => "https://jansuvidha.gov.in/income-certificate", "icon" => "💰"],
            ["title" => "Residence Certificate", "url" => "https://jansuvidha.gov.in/residence-certificate", "icon" => "🏠"]
        ]
    ],
    "property" => [
        "title" => "Property Services",
        "description" => "Property services include registration of property, payment of property tax, mutation services, and other related services. These services are essential for property owners to establish legal ownership and comply with government regulations.",
        "icon" => "🏠",
        "color" => "from-indigo-400 to-indigo-600",
        "links" => [
            ["title" => "Property Registration", "url" => "https://jansuvidha.gov.in/property-registration", "icon" => "📝"],
            ["title" => "Property Tax Payment", "url" => "https://jansuvidha.gov.in/property-tax", "icon" => "💰"],
            ["title" => "Mutation Services", "url" => "https://jansuvidha.gov.in/mutation", "icon" => "🔄"],
            ["title" => "Land Records", "url" => "https://jansuvidha.gov.in/land-records", "icon" => "📄"]
        ]
    ],
    "business" => [
        "title" => "Business Services",
        "description" => "Business services include company registration, GST registration, MSME registration, and other related services. These services are essential for entrepreneurs and business owners to establish and operate their businesses legally.",
        "icon" => "💼",
        "color" => "from-teal-400 to-teal-600",
        "links" => [
            ["title" => "MCA Portal", "url" => "https://www.mca.gov.in/", "icon" => "🏢"],
            ["title" => "GST Portal", "url" => "https://www.gst.gov.in/", "icon" => "💰"],
            ["title" => "MSME Registration", "url" => "https://udyamregistration.gov.in/", "icon" => "📝"],
            ["title" => "Startup India", "url" => "https://www.startupindia.gov.in/", "icon" => "🚀"]
        ]
    ],
    "india-government" => [
        "title" => "Indian Government Portal",
        "description" => "The National Portal of India is a single window access to information and services being provided by the various Indian Government entities. This portal is a Mission Mode Project under the National E-Governance Plan, designed and developed by National Informatics Centre (NIC).",
        "icon" => "🇮🇳",
        "color" => "from-orange-400 to-orange-600",
        "links" => [
            ["title" => "National Portal of India", "url" => "https://www.india.gov.in/", "icon" => "🏛️"],
            ["title" => "MyGov", "url" => "https://www.mygov.in/", "icon" => "👥"],
            ["title" => "Digital India", "url" => "https://www.digitalindia.gov.in/", "icon" => "💻"],
            ["title" => "Make in India", "url" => "https://www.makeinindia.com/", "icon" => "🏭"]
        ]
    ],
    "complaints" => [
        "title" => "Grievance Redressal",
        "description" => "The Government of India provides various platforms for citizens to file complaints and grievances against government departments and agencies. These platforms ensure transparency and accountability in governance.",
        "icon" => "📢",
        "color" => "from-red-400 to-red-600",
        "links" => [
            ["title" => "CPGRAMS", "url" => "https://pgportal.gov.in/", "icon" => "📝"],
            ["title" => "PMO Grievance", "url" => "https://www.pmindia.gov.in/en/grievance/", "icon" => "📬"],
            ["title" => "Consumer Helpline", "url" => "https://consumerhelpline.gov.in/", "icon" => "📞"],
            ["title" => "National Consumer Portal", "url" => "https://consumerhelpline.gov.in/", "icon" => "🏛️"]
        ]
    ],
    "disability-services" => [
        "title" => "Disability Services",
        "description" => "The Government of India provides various services and benefits for persons with disabilities. These services aim to ensure equal opportunities, protection of rights, and full participation of persons with disabilities in society.",
        "icon" => "♿",
        "color" => "from-blue-400 to-blue-600",
        "links" => [
            ["title" => "Department of Empowerment of PwD", "url" => "https://disabilityaffairs.gov.in/", "icon" => "🏛️"],
            ["title" => "UDID Portal", "url" => "https://udid.unique.gov.in/", "icon" => "🆔"],
            ["title" => "National Trust", "url" => "https://thenationaltrust.gov.in/", "icon" => "🤝"],
            ["title" => "Disability Pension", "url" => "https://nsap.nic.in/", "icon" => "💰"]
        ]
    ],
    "disasters-emergencies" => [
        "title" => "Disasters and Emergencies",
        "description" => "The Government of India has established various agencies and mechanisms to handle disasters and emergencies. These agencies provide relief and assistance to affected people during natural and man-made disasters.",
        "icon" => "🚨",
        "color" => "from-red-400 to-red-600",
        "links" => [
            ["title" => "NDMA", "url" => "https://ndma.gov.in/", "icon" => "🏛️"],
            ["title" => "NDRF", "url" => "https://ndrf.gov.in/", "icon" => "🚒"],
            ["title" => "Disaster Management", "url" => "https://www.ndma.gov.in/disaster-management", "icon" => "🌊"],
            ["title" => "Emergency Helpline", "url" => "https://ndma.gov.in/emergency-contacts", "icon" => "📞"]
        ]
    ],
    "education" => [
        "title" => "Education Services",
        "description" => "The Government of India provides various educational services and scholarships to promote education among citizens. These services aim to ensure quality education for all and promote research and innovation in the field of education.",
        "icon" => "📚",
        "color" => "from-green-400 to-green-600",
        "links" => [
            ["title" => "Ministry of Education", "url" => "https://www.education.gov.in/", "icon" => "🏛️"],
            ["title" => "National Scholarship Portal", "url" => "https://scholarships.gov.in/", "icon" => "💰"],
            ["title" => "SWAYAM", "url" => "https://swayam.gov.in/", "icon" => "💻"],
            ["title" => "DIKSHA", "url" => "https://diksha.gov.in/", "icon" => "📱"]
        ]
    ]
];

// Fetch service from URL
$service = isset($_GET['service']) ? $_GET['service'] : null;

// If service not found, set default service
if (!isset($serviceDetails[$service])) {
    $service = "india-government"; // Set the default service if no match found
}

$details = isset($serviceDetails[$service]) ? $serviceDetails[$service] : [
    "title" => "Service Not Found",
    "description" => "Sorry, we couldn't find any details for this service. Please check back later or visit the National Portal of India for more services.",
    "icon" => "❓",
    "color" => "from-gray-400 to-gray-600",
    "links" => [
        ["title" => "National Portal of India", "url" => "https://www.india.gov.in/", "icon" => "🏛️"]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $details['title']; ?> - e-Governance Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f6f8fc 0%, #e9f0f7 100%);
            min-height: 100vh;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .service-icon {
            font-size: 3rem;
            transition: all 0.3s ease;
        }
        .link-card {
            transition: all 0.3s ease;
            transform: translateY(0);
        }
        .link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .link-icon {
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        .link-card:hover .link-icon {
            transform: scale(1.1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="text-gray-800">
    <!-- Header -->
    <header class="glass-effect fixed top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                    e-Governance Portal
                </h1>
                <div class="flex items-center gap-6">
                    <span class="text-gray-600">Welcome, <?php echo $username; ?>!</span>
                    <nav class="hidden md:flex space-x-6">
                        <a href="home.php" class="text-gray-600 hover:text-blue-600">Home</a>
                        <a href="services.php" class="text-gray-600 hover:text-blue-600">Services</a>
                        <a href="appointments.php" class="text-gray-600 hover:text-blue-600">Appointments</a>
                    </nav>
                    <a href="logout.php" class="text-red-600 hover:text-red-700 font-medium">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Service Header -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8 animate-fade-in">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="service-icon bg-gradient-to-r <?php echo $details['color']; ?> text-white w-20 h-20 rounded-full flex items-center justify-center">
                        <?php echo $details['icon']; ?>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-4"><?php echo $details['title']; ?></h1>
                        <p class="text-gray-600 text-lg"><?php echo $details['description']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Service Links -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Available Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($details['links'] as $index => $link): ?>
                <div class="link-card bg-white rounded-xl shadow-lg p-6 animate-fade-in" 
                     style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="link-icon bg-gradient-to-r <?php echo $details['color']; ?> text-white w-12 h-12 rounded-full flex items-center justify-center">
                            <?php echo $link['icon']; ?>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800"><?php echo $link['title']; ?></h3>
                    </div>
                    <a href="<?php echo $link['url']; ?>" target="_blank" 
                       class="inline-block w-full text-center px-4 py-2 bg-gradient-to-r <?php echo $details['color']; ?> text-white rounded-lg hover:opacity-90 transition-opacity">
                        Visit Website
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Additional Information -->
            <div class="mt-12 bg-white rounded-xl shadow-lg p-8 animate-fade-in">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Important Information</h2>
                <div class="prose max-w-none text-gray-600">
                    <p>All the links provided above are official government websites. Please be cautious of any third-party websites claiming to provide these services.</p>
                    <p class="mt-4">For any assistance, you can:</p>
                    <ul class="list-disc pl-6 mt-2">
                        <li>Visit your nearest Common Service Centre (CSC)</li>
                        <li>Call the National Helpline: 1800-XXX-XXXX</li>
                        <li>Use the chatbot on our platform for instant assistance</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <!-- Floating Chat Button -->
    <button onclick="window.location.href='chatbot.php'" class="fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition-all transform hover:scale-110 z-50">
        <span class="text-2xl">💬</span>
    </button>

    <!-- Footer -->
    <footer class="glass-effect py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-600">
            <p>&copy; 2025 e-Governance Portal. All rights reserved.</p>
            <p class="mt-2 text-sm">This is a demonstration portal. All links are redirected to official government websites.</p>
        </div>
    </footer>
</body>
</html>
