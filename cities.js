var state_arr = new Array("Trivandrum", "Kollam", "Pathanamthitta", "Alappuzha", "Kottayam", "Idukki", "Ernakulam", "Thrissur", "Palakkad", "Malappuram", "Kozhikode", "Wayanad", "Kannur", "Kasaragod");

var s_a = new Array();
s_a[0]="";
s_a[1]=" Varkala | Attingal | Chirayinkeezhu | Nedumangad | Vamanapuram | Kazhakoottam | Vattiyoorkavu | Thiruvananthapuram | Nemom | Aruvikkara | Parassala | Kattakkada | Kovalam | Neyyattinkara ";
s_a[2]=" Karunagappally | Chavara | Kunnathur | Kottarakkara | Pathanapuram | Punalur | Chadayamangalam | Kundara | Kollam | Eravipuram | Chathannoor ";
s_a[3]=" Thiruvalla | Ranni | Aranmula | Konni | Adoor ";
s_a[4]=" Aroor | Cherthala | Alappuzha | Ambalappuzha | Kuttanad | Haripad | Kayamkulam | Mavelikkara | Chengannur ";
s_a[5]=" Pala | Kaduthuruthy | Vaikom | Ettumanoor | Kottayam | Puthuppally | Changanassery | Kanjirappally | Poonjar ";
s_a[6]=" Devikulam | Udumbanchola | Thodupuzha | Idukki | Peerumade ";
s_a[7]=" Perumbavoor | Angamaly | Aluva | Kalamassery | Paravur | Vypeen | Kochi | Thripunithura | Ernakulam | Thrikkakara | Kunnathunad | Piravom | Muvattupuzha | Kothamangalam ";
s_a[8]=" Chelakkara | Kunnamkulam | Guruvayoor | Manalur | Wadakkanchery | Ollur | Thrissur | Nattika | Kaipamangalam | Irinjalakuda | Puthukkad | Chalakudy | Kodungallur ";
s_a[9]=" Thrithala | Pattambi | Shornur | Ottappalam | Kongad | Mannarkkad | Malampuzha | Palakkad | Tarur | Chittur | Nemmara | Alathur ";
s_a[10]=" Kondotty | Ernad | Nilambur | Wandoor | Manjeri | Perinthalmanna | Mankada | Malappuram | Vengara | Vallikunnu | Tirurangadi | Tanur | Tirur | Kottakkal | Thavanur | Ponnani ";
s_a[11]=" Vadakara | Kuttiadi | Nadapuram | Quilandy | Perambra | Balusseri | Elathur | Kozhikode North | Kozhikode South | Beypore | Kunnamangalam | Koduvally | Thiruvambadi ";
s_a[12]=" Mananthavady | Sulthanbathery | Kalpetta ";
s_a[13]=" Payyannur | Kalliasseri | Taliparamba | Irikkur | Azhikode | Kannur | Dharmadam | Thalassery | Kuthuparamba | Mattannur | Peravoor ";
s_a[14]=" Manjeshwar | Kasaragod | Udma | Kanhangad | Trikaripur ";


function print_state(state_id){
	// given the id of the <select> tag as function argument, it inserts <option> tags
	var option_str = document.getElementById(state_id);
	option_str.length=0;
	option_str.options[0] = new Option('Select District','');
	option_str.selectedIndex = 0;
	for (var i=0; i<state_arr.length; i++) {
		option_str.options[option_str.length] = new Option(state_arr[i],state_arr[i]);
	}
}

function print_city(city_id, city_index){
	var option_str = document.getElementById(city_id);
	option_str.length=0;	// Fixed by Julian Woods
	option_str.options[0] = new Option('Select Assembly','');
	option_str.selectedIndex = 0;
	var city_arr = s_a[city_index].split("|");
	for (var i=0; i<city_arr.length; i++) {
		option_str.options[option_str.length] = new Option(city_arr[i],city_arr[i]);
	}
}

// Get references to the District, Assembly, and Self Govt. dropdowns
const districtSelect = document.getElementById("sts");
const assemblySelect = document.getElementById("state");
const selfGovtSelect = document.getElementById("selfgovt");


const selfGovtData = {
    "Trivandrum": {
        " Varkala ": ["Varkala Municipality", "Chemmaruthy", "Edava", "Elakamon", "Madavoor", "Navaikulam", "Pallickal", "Vettoor"],
    	" Attingal ": ["Attingal Municipality", "Cherunniyoor", "Karavaram", "Kilimanoor", "Manamboor", "Nagaroor", "Ottoor", "Pazhayakunnummel", "Pulimath", "Vakkom"],
    	" Chirayinkeezhu ": ["Anjuthengu", "Azhoor", "Chirayinkeezhu", "Kadakkavoor", "Kizhuvilam", "Mudakkal", "Kadinamkulam", "Mangalapuram"],
    	" Nedumangad ": ["Nedumangad Municipality", "Manikkal", "Karakulam", "Andoorkonam", "Pothencode", "Vembayam"],
    	" Vamanapuram ": ["Nellanad", "Pullampara", "Vamanapuram", "Anad", "Kallara", "Nanniyode", "Panavoor", "Pangode", "Peringamala"],
    	" Kazhakoottam ": ["Kazhakoottam", "Sreekaryam", "Wards No. 1 to 12","Ward 14","Ward 76","Ward 79 & 81"],
    	" Vattiyoorkavu ": ["Ward 13","Ward 15 to 25","Ward 31 to 36", "Kudappanakunnu", "Vattiyoorkavu"],
    	" Thiruvananthapuram ": ["Wards 26 to 30","Ward 40 to 47","Ward 59","Ward 60","Ward 69 to 75","Ward 77","Ward 78 & 80"],
    	" Nemom ": ["Ward 37 to 39","Ward 48 to 58","Ward 61 to 68"],
		" Aruvikkara ": ["Aruvikkara","Aryanad","Tholicode","Vithura","Kuttichal","Poovachal","Vellanad","Uzhamalackal","Nedumangad"],
		" Parassala ": ["Amboori","Aryancode","Kallikkad","Kollayil","Kunnathukal","Ottasekharamangalam","Parassala","Perumkadavila","Vellarada"],
		" Kattakkada ": ["Kattakkada","Malayinkeezhu","Maranalloor","Pallichal","Vilappil","Vilavoorkal"],
		" Kovalam ": ["Balaramapuram","Kalliyoor","Venganoor","Thiruvananathapuram","Kanjiramkulam","Karumkulam","Kottukal","Poovar","Vizhinjam"],
		" Neyyattinkara ": ["Neyyattinkara","Athiyannur","Chenkal","Karode","Kulathoor","Thirupuram","Neyyattinkara"]
        
    },
	"Kollam": {
		" Eravipuram ": ["Ward14","Ward 15"," Ward 20 to 41"," Mayyanad"],
		" Chathannoor ": ["Paravoor Municipality"," Adichanalloor"," Chathannoor"," Kalluvathukkal"," Poothakkulam"," Pooyappally"],
		" Karunagappally ": ["Alappad"," Clappana"," Kulasekharapuram"," Oachira"," Thazhava"," Thodiyoor"," Karunagappally"],
		" Chavara ": ["Ward 1 to 5","Ward 49"," Ward 50"," Chavara"," Neendakara"," Panmana"," Thekkumbhagom"," Thevalakkara"],
		" Kunnathur ": ["East Kallada"," Mundrothuruth Panchayats in Kollam Taluk"," Kunnathur"," Mynagappally"," Poruvazhy"," Sasthamcotta"," Sooranad North"," Sooranad South"," West Kallada"," Pavithreswaram"],
		" Kottarakkara ": ["Ezhukone"," Kareepra"," Kottarakkara"," Kulakkada"," Mylom"," Neduvathur"," Ummannoor"," Veliyam"],
		" Pathanapuram ": ["Melila"," Vettikkavala"," Pathanapuram"," Pattazhy"," Pattazhy Vadakkekara"," Piravanthoor"," Thalavoor"," Vilakkudy"],
		" Punalur ": ["Punalur Municipality"," Anchal"," Ariyankavu"," Edamulakkal"," Eroor"," Karavaloor"," Kulathupuzha"," Thenmala"],
		" Chadayamangalam ": ["Alayamon Panchayat in Pathanapuram Taluk"," Chadayamangalam"," Chithara"," Elamad"," Ittiva"," Kadakkal"," Nilamel"," Velinalloor"],
		" Kundara ": ["Elampalloor"," Kottamkara"," Kundara"," Nedumpana"," Perayam"," Perinad"," Thrikkovilvattom"],
		" Kollam ": ["Panayam"," Thrikkadavoor"," Thrikkaruva"," Ward No. 6 to 13"," Ward 16 to 19"," Ward 42 to 48"]
	},
	"Pathanamthitta": {
		" Thiruvalla ": ["Thiruvalla Municipality"," Kadapra"," Kaviyoor"," Kuttoor"," Nedumpram"," Niranam"," Peringara Panchayats in Thiruvalla Taluk"," Anicadu"," Kallooppara"," Mallappally"," Puramattom"," Kunnamthanam Panchayats in Mallappally Taluk"],
   		" Ranni ": ["Ezhumattoor"," Kottanad"," Kottangal Panchayats in Mallappally Taluk"," Ayiroor"," Naranammoozhi"," Ranni-Angadi"," Ranni-Pazhavangadi"," Ranni-Perunad"," Cherukole"," Ranni"," Vadasserikkara"," Vechoochira Panchayats in Ranni Taluk"],
   		" Aranmula ": ["Pathanamthitta Municipality"," Aranmula"," Chenneerkara"," Elanthoor"," Kozhenchery"," Kulanada"," Mallapuzhassery"," Mezhuveli"," Naranganam"," Omalloor Panchayats in Kozhenchery Taluk"," Eraviperoor"," Koipram"," Thottapuzhassery Panchayats in Thiruvalla Taluk"],
   		" Konni ": ["Aruvappulam"," Konni"," Malayalapuzha"," Pramadom"," Mylapra"," Vallicode"," Thannithode Panchayat in Kozhenchery Taluk"," Enadimangalam"," Kalanjoor Panchayats in Adoor Taluk"," Chittar"," Seethathodu Panchayats in Ranni Taluk"],
   		" Adoor ": ["Adoor Municipality"," Pandalam"," Thumbamon"," Pandalam Thekkekara"," Kodumon"," Ezhamkulam"," Erathu"," Pallickal"," Kadampanadu Panchayats in Adoor Taluk"]
	},
	"Alappuzha": {
		" Aroor ": ["Arookutty", "Aroor", "Chennam-Pallippuram", "Ezhupunna", "Kodamthuruth", "Kuthiathode", "Panavally", "Perumbalam", "Thycattussery", "Thuravoor Panchayat in Cherthala Taluk"],
    " Cherthala ": ["Cherthala Municipality", "Cherthala South", "Kadakkarappally", "Kanjikkuzhi", "Muhamma", "Pattanakkad", "Thanneermukkam", "Vayalar Panchayats in Cherthala Taluk"],
    " Alappuzha ": ["Alappuzha Municipality", "Wards no. 1-19 & 45-50", "Aryad", "Mannanchery", "Mararikkulam South Panchayats in Ambalappuzha Taluk", "Mararikkulam North Panchayat in Cherthala Taluk"],
    " Ambalappuzha ": ["Alappuzha Municipality Wards no. 20 to 44", "Ambalappuzha North", "Ambalappuzha South", "Punnapra North", "Punnapra South", "Purakkad Panchayats in Ambalappuzha Taluk"],
    " Kuttanad ": ["Champakkulam", "Edathua", "Kainakary", "Kavalam", "Muttar", "Nedumudi", "Neelamperoor", "Pulinkunnu", "Ramankary", "Thakazhy", "Thalavady", "Veliyanad Panchayats in Kuttanad Taluk", "Veeyapuram Panchayat in Karthikappally Taluk"],
    " Haripad ": ["Arattupuzha", "Cheppad", "Cheruthana", "Chingoli", "Haripad", "Karthikappally", "Karuvatta", "Kumarapuram", "Muthukulam", "Pallippad", "Thrikkunnapuzha"],
    " Kayamkulam ": ["Kayamkulam Municipality", "Devikulangara", "Kandalloor", "Krishnapuram", "Pathiyoor", "Bharanikkavu", "Chettikulangara"],
    " Mavelikkara ": ["Mavelikkara Municipality", "Chunakkara", "Mavelikkara–Thekkekara", "Mavelikkara-Thamarakkulam", "Nooranad", "Palamel", "Thazhakara", "Vallikunnam"],
    " Chengannur ": ["Chengannur Municipality", "Ala", "Budhanoor", "Cheriyanad", "Mannar", "Mulakuzha", "Pandanad", "Puliyoor", "Thiruvanvandoor", "Venmony", "Chennithala","Thriperumthura"]
	},
	"Kottayam": {
		" Vaikom ": ["Vaikom Municipality", "Chempu", "Kallara", "Maravanthuruthu", "T.V. Puram", "Thalayazham", "Thalayolaparambu", "Udayanapuram", "Vechoor", "Velloor Panchayats in Vaikom Taluk"],
    " Ettumanoor ": ["Aymanam", "Arpookara", "Athirampuzha", "Ettumanoor", "Kumarakom", "Neendoor", "Thiruvarppu Panchayats in Kottayam Taluk"],
    " Kottayam ": ["Kottayam Municipality", "Kumaranalloor", "Nattakom", "Panachikkad", "Vijayapuram Panchayats in Kottayam Taluk"],
    " Puthuppally ": ["Akalakunnam", "Ayarkunnam", "Kooroppada", "Manarcad", "Meenadom", "Pampady", "Puthuppally Panchayats in Kottayam Taluk", "Vakathanam Panchayat in Changanassery Taluk"],
    " Changanassery ": ["Changanassery Municipality", "Kurichy", "Madappally", "Paippad", "Thrikkodithanam", "Vazhappally Panchayats in Changanassery Taluk"],
    " Kanjirappally ": ["Chirakkadavu", "Kanjirappally", "Manimala Panchayats in Kanjirappilly taluk", "Kangazha", "Karukachal", "Nedumkunnam", "Vazhoor", "Vellavoor Panchayats in Changanassery Taluk", "Pallikkathode Panchayat in Kottayam Taluk"],
    " Poonjar ": ["Erumeli", "Koottickal", "Mundakayam", "Parathode Panchayats in Kanjirappally Taluk", "Erattupetta", "Poonjar", "Poonjar Thekkekara", "Teekoy", "Thidanad Panchayats in Meenachil Taluk"],
    " Pala ": ["Pala Municipality", "Bharananganam", "Kadanad", "Karoor", "Kozhuvanal", "Meenachil", "Melukavu", "Moonnilavu", "Mutholy", "Ramapuram", "Thalanad", "Thalappalam Panchayats in Meenachil Taluk", "Elikkulam Panchayat in Kanjirappally Taluk"],
    " Kaduthuruthy ": ["Kadaplamattom", "Kanakkari", "Kidangoor", "Kuravilangad", "Marangattupilly", "Uzhavoor", "Veliyannoor Panchayats in Meenachil Taluk", "Kaduthuruthy", "Manjoor", "Mulakulam", "Neezhoor Panchayats in Vaikom taluk"]

	},
	"Idukki": {
		" Devikulam ": ["Adimali", "Kanthalloor", "Mankulam", "Marayoor", "Munnar", "Pallivasal", "Vattavada", "Vellathooval Panchayats in Devikulam taluk", "Bisonvalley", "Chinnakanal Panchayat in Udumbanchola Taluk"],
		" Udumbanchola ": ["Erattayar", "Karunapuram", "Nedumkandam", "Pampadumpara", "Rajakkad", "Rajakumari", "Santhanpara", "Senapathy", "Udumbanchola", "Vandanmedu Panchayats in Udumbanchola Taluk"],
		" Thodupuzha ": ["Thodupuzha Municipality", "Alacode", "Edavetty", "Karimannoor", "Karimkunnam", "Kodikulam", "Kumaramangalam", "Manakkad", "Muttom", "Purapuzha", "Udumbannoor", "Vannapuram", "Velliyamattom Panchayats in Thodupuzha Taluk"],
		" Idukki ": ["Arakkulam", "Idukki-Kanjikuzhi", "Kudayathoor", "Vazhathope Panchayats in Thodupuzha Taluk", "Kamakshy", "Kanchiyar", "Kattappana", "Konnathady", "Mariapuram", "Vathikudy Panchayats in Udumbanchola Taluk"],
		" Peerumade ": ["Ayyappancoil", "Chakkupallam Panchayats in Udumbanchola Taluk", "Elappara", "Kokkayar", "Kumily", "Peerumade", "Peruvanthanam", "Upputhara", "Vandiperiyar Panchayats in Peerumade Taluk"]
	},
	"Ernakulam": {
		" Perumbavoor ": ["Perumbavoor Municipality", "Asamannoor", "Koovappady", "Mudakkuzha", "Okkal", "Rayamangalam", "Vengola", "Vengoor Panchayats in Kunnathunad Taluk"],
		" Angamaly ": ["Angamaly Municipality", "Ayyampuzha", "Kalady", "Karukutty", "Malayattoor-Neeleswaram", "Manjapra", "Mookkannoor", "Parakkadavu", "Thuravoor Panchayats in Aluva Taluk"],
		" Aluva ": ["Aluva Municipality", "Chengamanad", "Choornikkara", "Edathala", "Kanjoor", "Keezhmad", "Nedumbassery", "Sreemolnagaram Panchayats in Aluva Taluk"],
		" Kalamassery ": ["Kalamassery Municipality in Kanayannur Taluk", "Alangad", "Eloor", "Kadungalloor", "Kunnukara", "Karumalloor Panchayats in Paravoor Taluk"],
		" Paravur ": ["North Paravur Municipality", "Chendamangalam", "Chittattukara", "Ezhikkara", "Kottuvally", "Puthenvelikkara", "Varappuzha", "Vadakkekara Panchayats in Paravoor Taluk"],
		" Vypeen ": ["Kadamakudy", "Mulavukad Panchayats in Kanayannur Taluk", "Edavanakkad", "Elamkunnapuzha", "Kuzhuppilly", "Nayarambalam", "Njarakkal", "Pallippuram Panchayats in Kochi Taluk"],
		" Kochi ": ["Kumbalangi", "Chellanam Panchayats", "Wards No.1 to 10 and 19 to 25 of Kochi (M.Corporation) in Kochi Taluk"],
		" Thripunithura ": ["Thripunithura Municipality", "Kumbalam", "Maradu", "Udayamperoor Panchayats in Kanayannur Taluk", "Wards No.11 to 18 of Kochi (M.Corporation) in Kochi Taluk"],
		" Ernakulam ": ["Ward No.26 of Kochi (M.Corporation) in Kochi Taluk", "Cheranalloor Panchayat in Kanayannur Taluk", "Wards No.27 to 30, 32, 35 & 52 to 66 of Kochi (M.Corporation) in Kanayannur Taluk"],
		" Thrikkakara ": ["Wards No.31, 33, 34 & 36 to 51 of Kochi (M.Corporation)", "Thrikkakara Panchayat in Kanayannur Taluk"],
		" Kunnathunad ": ["Aikaranad", "Kizhakkambalam", "Kunnathunad", "Mazhuvannoor", "Poothrikka", "Thiruvaniyoor", "Vadavucode-Puthencruz", "Vazhakulam Panchayats in Kunnathunad Taluk"],
		" Piravom ": ["Amballoor", "Edakkattuvayal", "Chottanikkara", "Mulanthuruthy", "Thiruvankulam Panchayat in Kanayannur Taluk", "Elanji", "Koothattukulam", "Maneed", "Pampakuda", "Piravom", "Ramamangalam", "Thirumarady Panchayats in Muvattupuzha Taluk"],
		" Muvattupuzha ": ["Muvattupuzha Municipality", "Arakuzha", "Avoly", "Ayavana", "Kalloorkad", "Manjalloor", "Marady", "Paipra", "Palakkuzha", "Valakom Panchayats in Muvattupuzha Taluk", "Paingottoor", "Pothanicad Panchayats in Kothamangalam Taluk"],
		" Kothamangalam ": ["Kothamangalam Municipality", "Kavalangad", "Keerampara", "Kottappady", "Kuttampuzha", "Nellikkuzhi", "Pallarimangalam", "Pindimana", "Varappetty Panchayats in Kothamangalam Taluk"]
	},	
			"Thrissur": {

				" Ollur ": ["Madakkathara", "Nadathara", "Pananchery", "Puthur Panchayats", "Wards No.12, 13, 23 to 31, 40 to 42 of Thrissur"],
				" Thrissur ": ["Wards No.1 to 11, 14 to 22, 32 to 39 & 43 to 50 of Thrissur (M. Corporation) in Thrissur Taluk"],
				" Nattika ": ["Anthikkad", "Avinissery", "Chazhoor", "Cherpu", "Paralam", "Thanniyam Panchayats in Thrissur Taluk", "Nattika", "Valappad", "Talikkulam Panchayats in Chavakkad Taluk"],
				" Kaipamangalam ": ["Edavilangu", "Edathiruthy", "Eriyad", "Kaipamangalam", "Mathilakam", "Perinjanam", "Sreenarayanapuram Panchayats in Kodungallor Taluk"],
				" Irinjalakuda ": ["Irinjalakuda Municipality", "Alur", "Karalam", "Kattur", "Muriyad", "Padiyur", "Poomangalam", "Porathissery", "Velookkara Panchayats in Mukundapuram Taluk"],
				" Puthukkad ": ["Alagappanagar", "Mattathur", "Nenmanikkara", "Parappukkara", "Puthukkad", "Varandarappilly", "Trikkur Panchayats in Mukundapuram Taluk", "Vallachira Panchayat in Thrissur Taluk"],
				" Chalakudy ": ["Chalakkudy Municipality", "Athirappilly", "Kadukutty", "Kodakara", "Kodassery", "Koratty", "Melur", "Pariyaram Panchayats in Mukundapuram Taluk"],
				" Kodungallur ": ["Kodungallur Municipality", "Methala", "Poyya Panchayats in Kodungaloor Taluk", "Annamanada", "Kuzhur", "Mala", "Puthenchira", "Vellangallur Panchayats in Mukundapuram Taluk"],
				" Chelakkara ": ["Chelakkara", "Desamangalam", "Kondazhy", "Mullurkara", "Panjal", "Pazhayannur", "Thiruvilwamala", "Vallatholenagar", "Varavoor Panchayats in Thalappilly Taluk"],
				" Kunnamkulam ": ["Kunnamkulam Municipality", "Chowannur", "Erumapetty", "Kadangode", "Kadavallur", "Kattakampal", "Porkulam", "Velur Panchayats in Thalappilly Taluk"],
				" Guruvayoor ": ["Chavakkad Municipality", "Guruvayoor Municipality", "Kadappuram", "Orumanayur", "Pookode", "Punnayur", "Punnayurkulam", "Engandiyur", "Vadakkekad Panchayats in Chavakkad Taluk"],
				" Manalur ": ["Arimpur", "Manalur Panchayats in Thrissur Taluk", "Choondal", "Kandanassery Panchayats in Thalappilly Taluk", "Elavally", "Mullassery", "Vatanappally", "Pavaratty", "Thaikkad", "Venkitangu Panchayats in Chavakkad Taluk"],
				" Wadakkanchery ": ["Adat", "Avanur", "Kaiparamba", "Kolazhy", "Mulamkunnathukavu", "Tholur Panchayats in Thrissur Taluk", "Mundathikode", "Wadakkanchery", "Thekkumkara Panchayats in Thalappilly Taluk"]
			},
			"Palakkad": {
				" Thrithala ": ["Anakkara", "Chalissery", "Kappur", "Nagalassery", "Parudur", "Pattithara", "Thirumittacode", "Thrithala Panchayats in Ottappalam Taluk"],
				" Pattambi ": ["Koppam", "Kulukkallur", "Muthuthala", "Ongallur", "Pattambi", "Thiruvegapura", "Vallapuzha", "Vilayur Panchayats in Ottappalam Taluk"],
				" Shornur ": ["Shornur Municipality", "Ananganadi", "Chalavara", "Cherpulasserry", "Nellaya", "Thrikkadeeri", "Vaniyamkulam", "Vellinezhi Panchayats in Ottappalam Taluk"],
				" Ottappalam ": ["Ottappalam Municipality", "Ambalapara", "Kadampazhipuram", "Karimpuzha", "Lakkidi-Perur", "Pookkottukavu", "Sreekrishnapuram", "Thachanattukara Panchayats in Ottappalam Taluk"],
				" Kongad ": ["Kanhirapuzha", "Karakurissi", "Thachampara", "Karimba Panchayats in Mannarkkad Taluk", "Keralassery", "Kongad", "Mankara", "Mannur", "Parali Panchayats in Palakkad Taluk"],
				" Mannarkkad ": ["Agali", "Alanallur", "Kottoppadam", "Kumaramputhur", "Mannarkkad", "Pudur", "Sholayur Panchayat in Mannarkkad Taluk"],
				" Malampuzha ": ["Akathethara", "Elappully", "Kodumba", "Malampuzha", "Marutharoad", "Mundur", "Pudussery", "Puduppariyaram Panchayats in Palakkad Taluk"],
				" Palakkad ": ["Palakkad Municipality", "Kannadi", "Pirayiri Panchayats in Palakkad Taluk", "Mathur Panchayat in Alathur Taluk"],
				" Tarur ": ["Kannambra", "Kavasseri", "Kottayi", "Kuthanur", "Peringottukurissi", "Puducode", "Tarur", "Vadakkencheri Panchayats in Alathur Taluk"],
				" Chittur ": ["Chittur-Thathamangalam Municipality", "Eruthempathy", "Kozhinjampara", "Nalleppilly", "Pattanchery", "Perumatty", "Vadakarapathy Panchayats in Chittur Taluk", "Peruvemba", "Polpully Panchayats in Palakkad Taluk"],
				" Nemmara ": ["Elavenchery", "Koduvayur", "Kollengode", "Muthalamada", "Nelliyampathy", "Nemmara", "Pallassana", "Ayiloor", "Puthunagaram", "Vadavannur Panchayat in Chittur Taluk"],
				" Alathur ": ["Alathur", "Erimayur", "Kizhakkencheri", "Kuzhalmannam", "Melarcode", "Thenkurissi", "Vandazhi Panchayats in Alathur Taluk"]
			},
			"Malappuram": {
				" Kondotty ": ["Cheacode", "Cherukavu", "Kondotty", "Pulikkal", "Vazhakkad", "Nediyiruppu", "Vazhayur Panchayats in Ernad Taluk"],
				" Ernad ": ["Chaliyar Panchayat in Nilambur Taluk", "Areacode", "Edavanna", "Kavannoor", "Kizhuparamba", "Urangattiri", "Kuzhimanna Panchayats in Ernad Taluk"],
				" Nilambur ": ["Amarambalam", "Chungathara", "Edakkara", "Karulai", "Moothedam", "Nilambur", "Pothukal", "Vazhikkadavu Panchayats in Nilambur Taluk"],
				" Wandoor ": ["Chokkad", "Kalikavu", "Karuvarakundu", "Mampad", "Porur", "Thiruvali", "Thuvvur", "Wandoor Panchayats in Nilambur Taluk"],
				" Manjeri ": ["Manjeri Municipality", "Pandikkad", "Trikkalangode Panchayats in Ernad Taluk", "Edappatta", "Keezhattur Panchayats in Perinthalmanna Taluk"],
				" Perinthalmanna ": ["Perinthalmanna Municipality", "Aliparamba", "Elamkulam", "Pulamanthole", "Thazhekode", "Vettathur", "Melattur Panchayats in Perinthalmanna Taluk"],
				" Mankada ": ["Angadippuram", "Koottilangadi", "Kuruva", "Makkaraparamba", "Mankada", "Moorkkanad", "Puzhakkattiri Panchayats in Perinthalmanna Taluk"],
				" Malappuram ": ["Malappuram Municipality", "Morayur", "Pookkottur", "Anakkayam", "Pulpatta Panchayats in Ernad Taluk", "Kodur Panchayat in Perinthalmanna Taluk"],
				" Vengara ": ["Abdu Rahiman Nagar", "Kannamangalam", "Othukkungal", "Parappur", "Urakam", "Vengara Panchayats in Tirurangadi Taluk"],
				" Vallikunnu ": ["Chelembra", "Moonniyur", "Pallikkal", "Peruvallur", "Thenhippalam", "Vallikkunnu Panchayats in Tirurangadi Taluk"],
				" Tirurangadi ": ["Edarikode", "Nannambra", "Parappanangadi", "Thennala", "Tirurangadi Panchayats in Tirurangadi Taluk", "Perumanna Clari Panchayat in Tirur Taluk"],
				" Tanur ": ["Cheriyamundam", "Niramaruthur", "Ozhur", "Ponmundam", "Thanalur", "Tanur Panchayats in Tirur Taluk"],
				" Tirur ": ["Tirur Municipality", "Athavanad", "Kalpakancheri", "Thalakkad", "Thirunavaya", "Valavannur", "Vettom Panchayats in Tirur Taluk"],
				" Kottakkal ": ["Edayoor", "Irimbiliyam", "Kottakkal", "Kuttippuram", "Marakkara", "Ponmala", "Valanchery Panchayats in Tirur Taluk"],
				" Thavanur ": ["Edappal", "Thavanur", "Vattamkulam Panchayats in Ponnani Taluk", "Purathur", "Mangalam", "Thriprangode Panchayats in Tirur Taluk"],
				" Ponnani ": ["Ponnani Municipality", "Alamcode", "Maranchery", "Nannamukku", "Perumpadappa", "Veliyankode Panchayats in Ponnani Taluk"]
			},
			"Kozhikode": {
				" Vadakara ": ["Vadakara Municipality", "Azhiyur", "Chorode", "Eramala", "Onchiam Panchayats in Vadakara Taluk"],
				" Kuttiadi ": ["Ayancheri", "Kunnummal", "Kuttiadi", "Purameri", "Thiruvallur", "Velom", "Maniyur", "Villiappally Panchayats in Vadakara Taluk"],
				" Nadapuram ": ["Chekkiad", "Edacheri", "Kavilumpara", "Kayakkodi", "Maruthonkara", "Nadapuram", "Narippatta", "Thuneri", "Valayam", "Vanimel Panchayats in Vadakara Taluk"],
				" Quilandy ": ["Quilandy Municipality", "Chemancheri", "Chengottukavu", "Moodadi", "Payyoli", "Thikkody Panchayats in Quilandy Taluk"],
				" Perambra ": ["Arikkulam", "Chakkittapara", "Changaroth", "Cheruvannur", "Keezhariyur", "Koothali", "Meppayyur", "Nochad", "Perambra", "Thurayur Panchayats in Quilandy Taluk"],
				" Balusseri ": ["Atholi", "Balusseri", "Kayanna", "Koorachundu", "Kottur", "Naduvannur", "Panangad", "Ulliyeri", "Unnikulam Panchayats in Quilandy Taluk"],
				" Elathur ": ["Chelannur", "Elathur", "Kakkodi", "Kakkur", "Kuruvattur", "Nanmanda", "Thalakkulathur Panchayats in Kozhikode Taluk"],
				" Kozhikode North ": ["Wards No.1 to 16", "39", "40", "42 to 51 of Kozhikode (M. Corporation) in Kozhikode Taluk"],
				" Kozhikode South ": ["Wards No. 17 to 38", "41 of Kozhikode (M. Corporation) in Kozhikode Taluk"],
				" Beypore ": ["Beypore", "Cheruvannur-Nallalam", "Feroke", "Kadalundi", "Ramanattukara Panchayats in Kozhikode Taluk"],
				" Kunnamangalam ": ["Chathamangalam", "Kunnamangalam", "Mavoor", "Olavanna", "Perumanna", "Peruvayal Panchayats in Kozhikode Taluk"],
				" Koduvally ": ["Kizhakkoth", "Koduvally", "Madavoor", "Narikkuni", "Omassery", "Thamarassery Panchayats in Kozhikode Taluk"],
				" Thiruvambadi ": ["Karassery", "Kodencheri", "Kodiyathur", "Koodaranji", "Mukkom", "Puthuppadi", "Thiruvambadi Panchayats in Kozhikode Taluk"]
			},
			"Wayanad": {
				" Mananthavady ": ["Edavaka", "Mananthavady", "Panamaram", "Thavinhal", "Thirunelly", "Thondernad", "Vellamunda Panchayats in Mananthavady Taluk"],
				" Sulthanbathery ": ["Ambalavayal", "Meenangadi", "Mullenkolly", "Nenmeni", "Noolpuzha", "Poothadi", "Pulpalli", "Sulthanbathery Panchayats in Sultanbathery Taluk"],
				" Kalpetta ": ["Kalpetta Municipality", "Kaniambetta", "Kottathara", "Meppady", "Muppainad", "Muttil", "Padinharethara", "Pozhuthana", "Thariyode", "Vengappally", "Vythiri Panchayats in Vythiri Taluk"]			
			},
			"Kannur": {
				" Payyannur ": ["Payyannur Municipality", "Cherupuzha", "Eramamkuttoor", "Kankole–Alapadamba", "Karivellur", "Peralam", "Peringome", "Vayakkara", "Ramanthali Panchayats in Taliparamba Taluk"],
				" Kalliasseri ": ["Cherukunnu", "Cheruthazham", "Ezhome", "Kadannappalli-Panapuzha", "Kalliasseri", "Kannapuram", "Kunhimangalam", "Madayi", "Mattool Panchayats in Kannur Taluk", "Pattuvam Panchayat in Taliparamba Taluk"],
				" Taliparamba ": ["Taliparamba Municipality", "Chapparapadavu", "Kurumathur", "Kolacherry", "Kuttiattoor", "Malapattam", "Mayyil", "Pariyaram Panchayats in Taliparamba Taluk"],
				" Irikkur ": ["Chengalayi", "Eruvassy", "Irikkur", "Payyavoor", "Sreekandapuram", "Alakode", "Naduvil", "Udayagiri", "Ulikkal Panchayats in Taliparamba Taluk"],
				" Azhikode ": ["Azhikode", "Chirakkal", "Narath", "Pallikkunnu", "Pappinisseri", "Puzhathi", "Valapattanam Panchayats in Kannur Taluk"],
				" Kannur ": ["Kannur Municipality", "Chelora", "Edakkad", "Elayavoor", "Munderi Panchayats in Kannur Taluk"],
				" Dharmadam ": ["Anjarakandy", "Chembilode", "Kadambur", "Muzhappilangad", "Peralasseri Panchayats in Kannur Taluk", "Dharmadam", "Pinarayi", "Vengad Panchayats in Thalaseery Taluk"],
				" Thalassery ": ["Thalassery Municipality", "Chockli", "Eranholi", "Kadirur", "New–Mahe", "Panniyannur Panchayats in Thalassery Taluk"],
				" Kuthuparamba ": ["Kuthuparamba Municipality", "Kariyad", "Kottayam –Malabar", "Kunnothuparambu", "Mokeri", "Panoor", "Pattiom", "Peringalam", "Thriprangottur Panchayats in Thalassery Taluk"],
				" Mattannur ": ["Mattannur Municipality", "Chittariparamba", "Keezhallur", "Koodali", "Malur", "Mangattidam", "Kolayad", "Thillenkeri Panchayats in Thalassery Taluk", "Padiyur-Kalliad Panchayat in Taliparamba Taluk"],
				" Peravoor ": ["Aralam", "Ayyankunnu", "Kanichar", "KeezhurChavassery", "Kelakam", "Kottiyoor", "Muzhakkunnu", "Payam", "Peravoor Panchayats in Thalassery Taluk"]
			},
			"Kasaragod": {
				" Manjeshwar ": ["Enmakaje", "Kumbla", "Mangalpady", "Manjeshwar", "Meenja", "Paivalike", "Puthige", "Vorkady Panchayats in Kasaragod Taluk"],
				" Kasaragod ": ["Kasaragod Municipality", "Badiadka", "Bellur", "Chengala", "Karadka", "Kumbdaje", "Madhur", "Mogral Puthur Panchayats in Kasaragod Taluk"],
				" Udma ": ["Bedadka", "Chemnad", "Delampady", "Kuttikole", "Muliyar Panchayats in Kasaragod Taluk", "Pallikere", "Pullur-Periya", "Udma Panchayats in Hosdurg Taluk"],
				" Kanhangad ": ["Kanhangad Muncipality", "Ajanur", "Balal", "Kallar", "Kinanoor – Karindalam", "Kodom-Belur", "Madikai", "Panathady Panchayats in Hosdurg Taluk"],
				" Trikaripur ": ["Cheruvathur", "East Eleri", "Kayyur-Cheemeni", "Nileshwar", "Padne", "Pilicode", "Trikaripur", "Valiyaparamba", "West Eleri Panchayats in Hosdurg Taluk"]				
			}


	
};


function populateSelfGovt() {
    const selectedDistrict = districtSelect.value;
    const selectedAssembly = assemblySelect.value;

    
    selfGovtSelect.innerHTML = '<option value="" selected disabled> </option>';

    
    if (selfGovtData[selectedDistrict] && selfGovtData[selectedDistrict][selectedAssembly]) {
        const selfGovtOptions = selfGovtData[selectedDistrict][selectedAssembly];

        
        selfGovtOptions.forEach((option) => {
            const optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            selfGovtSelect.appendChild(optionElement);
        });
    }
}


districtSelect.addEventListener("change", populateSelfGovt);
assemblySelect.addEventListener("change", populateSelfGovt);


populateSelfGovt();
