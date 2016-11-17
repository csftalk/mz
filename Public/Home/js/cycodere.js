(function() {
    var e = ["usual", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
    var d = {
        usual: [{
            country: "中国",
            code: "0086",
            brief: "CN"
        }, {
            country: "台湾",
            code: "00886",
            brief: "TW"
        }, {
            country: "中国香港",
            code: "00852",
            brief: "HK"
        }, {
            country: "Brazil",
            code: "0055",
            brief: "BR"
        }, {
            country: "India",
            code: "0091",
            brief: "IN"
        }, {
            country: "Indonesia",
            code: "0062",
            brief: "ID"
        }, {
            country: "Malaysia",
            code: "0060",
            brief: "MY"
        }],
        A: [{
            brief: "AD",
            country: "Andorra",
            code: "00376"
        }, {
            brief: "AF",
            country: "Afghanistan",
            code: "0093"
        }, {
            brief: "AG",
            country: "Antigua and Barbuda",
            code: "001"
        }, {
            brief: "AI",
            country: "Anguilla",
            code: "001"
        }, {
            brief: "AL",
            country: "Albania",
            code: "00355"
        }, {
            brief: "AM",
            country: "Armenia",
            code: "00374"
        }, {
            brief: "AO",
            country: "Angola",
            code: "00244"
        }, {
            brief: "AR",
            country: "Argentina",
            code: "0054"
        }, {
            brief: "AS",
            country: "American Samoa",
            code: "001"
        }, {
            brief: "AT",
            country: "Austria",
            code: "0043"
        }, {
            brief: "AU",
            country: "Australia",
            code: "0061"
        }, {
            brief: "AW",
            country: "Aruba",
            code: "00297"
        }, {
            brief: "AZ",
            country: "Azerbaijan",
            code: "00994"
        }, {
            brief: "DZ",
            country: "Algeria",
            code: "00213"
        }],
        B: [{
            brief: "BA",
            country: "Bosnia and Herzegovina",
            code: "00387"
        }, {
            brief: "BB",
            country: "Barbados",
            code: "001"
        }, {
            brief: "BD",
            country: "Bangladesh",
            code: "00880"
        }, {
            brief: "BE",
            country: "Belgium",
            code: "0032"
        }, {
            brief: "BF",
            country: "Burkina Faso",
            code: "00226"
        }, {
            brief: "BG",
            country: "Bulgaria",
            code: "00359"
        }, {
            brief: "BH",
            country: "Bahrain",
            code: "00973"
        }, {
            brief: "BI",
            country: "Burundi",
            code: "00257"
        }, {
            brief: "BJ",
            country: "Benin",
            code: "00229"
        }, {
            brief: "BM",
            country: "Bermuda",
            code: "001"
        }, {
            brief: "BN",
            country: "Brunei",
            code: "00673"
        }, {
            brief: "BO",
            country: "Bolivia",
            code: "00591"
        }, {
            brief: "BQ",
            country: "Bonaire, Sint Eustatius and Saba",
            code: "00599"
        }, {
            brief: "BR",
            country: "Brazil",
            code: "0055"
        }, {
            brief: "BS",
            country: "Bahamas",
            code: "001"
        }, {
            brief: "BT",
            country: "Bhutan",
            code: "00975"
        }, {
            brief: "BW",
            country: "Botswana",
            code: "00267"
        }, {
            brief: "BY",
            country: "Belarus",
            code: "00375"
        }, {
            brief: "BZ",
            country: "Belize",
            code: "00501"
        }, {
            brief: "IO",
            country: "British Indian Ocean Territory",
            code: "00246"
        }, {
            brief: "VG",
            country: "British Virgin Islands",
            code: "001"
        }],
        C: [{
            brief: "CA",
            country: "Canada",
            code: "001"
        }, {
            brief: "CC",
            country: "Cocos Islands",
            code: "0061"
        }, {
            brief: "CF",
            country: "Central African Republic",
            code: "00236"
        }, {
            brief: "CG",
            country: "Congo",
            code: "00242"
        }, {
            brief: "CI",
            country: "Côte d'Ivoire",
            code: "00225"
        }, {
            brief: "CK",
            country: "Cook Islands",
            code: "00682"
        }, {
            brief: "CL",
            country: "Chile",
            code: "0056"
        }, {
            brief: "CM",
            country: "Cameroon",
            code: "00237"
        }, {
            brief: "CN",
            country: "China",
            code: "0086"
        }, {
            brief: "CO",
            country: "Colombia",
            code: "0057"
        }, {
            brief: "CR",
            country: "Costa Rica",
            code: "00506"
        }, {
            brief: "CU",
            country: "Cuba",
            code: "0053"
        }, {
            brief: "CV",
            country: "Cape Verde",
            code: "00238"
        }, {
            brief: "CW",
            country: "Curaçao",
            code: "00599"
        }, {
            brief: "CX",
            country: "Christmas Island",
            code: "0061"
        }, {
            brief: "CY",
            country: "Cyprus",
            code: "00357"
        }, {
            brief: "CZ",
            country: "Czech Republic",
            code: "00420"
        }, {
            brief: "HR",
            country: "Croatia",
            code: "00385"
        }, {
            brief: "KH",
            country: "Cambodia",
            code: "00855"
        }, {
            brief: "KM",
            country: "Comoros",
            code: "00269"
        }, {
            brief: "KY",
            country: "Cayman Islands",
            code: "001"
        }, {
            brief: "TD",
            country: "Chad",
            code: "00235"
        }],
        D: [{
            brief: "DJ",
            country: "Djibouti",
            code: "00253"
        }, {
            brief: "DK",
            country: "Denmark",
            code: "0045"
        }, {
            brief: "DM",
            country: "Dominica",
            code: "001"
        }, {
            brief: "DO",
            country: "Dominican Republic",
            code: "001"
        }],
        E: [{
            brief: "EC",
            country: "Ecuador",
            code: "00593"
        }, {
            brief: "EE",
            country: "Estonia",
            code: "00372"
        }, {
            brief: "EG",
            country: "Egypt",
            code: "0020"
        }, {
            brief: "ER",
            country: "Eritrea",
            code: "00291"
        }, {
            brief: "ET",
            country: "Ethiopia",
            code: "00251"
        }, {
            brief: "GQ",
            country: "Equatorial Guinea",
            code: "00240"
        }, {
            brief: "SV",
            country: "El Salvador",
            code: "00503"
        }],
        F: [{
            brief: "FI",
            country: "Finland",
            code: "00358"
        }, {
            brief: "FJ",
            country: "Fiji",
            code: "00679"
        }, {
            brief: "FK",
            country: "Falkland Islands",
            code: "00500"
        }, {
            brief: "FO",
            country: "Faroe Islands",
            code: "00298"
        }, {
            brief: "FR",
            country: "France",
            code: "0033"
        }, {
            brief: "GF",
            country: "French Guiana",
            code: "00594"
        }, {
            brief: "PF",
            country: "French Polynesia",
            code: "00689"
        }],
        G: [{
            brief: "DE",
            country: "Germany",
            code: "0049"
        }, {
            brief: "GA",
            country: "Gabon",
            code: "00241"
        }, {
            brief: "GD",
            country: "Grenada",
            code: "001"
        }, {
            brief: "GE",
            country: "Georgia",
            code: "00995"
        }, {
            brief: "GG",
            country: "Guernsey",
            code: "0044"
        }, {
            brief: "GH",
            country: "Ghana",
            code: "00233"
        }, {
            brief: "GI",
            country: "Gibraltar",
            code: "00350"
        }, {
            brief: "GL",
            country: "Greenland",
            code: "00299"
        }, {
            brief: "GM",
            country: "Gambia",
            code: "00220"
        }, {
            brief: "GN",
            country: "Guinea",
            code: "00224"
        }, {
            brief: "GP",
            country: "Guadeloupe",
            code: "00590"
        }, {
            brief: "GR",
            country: "Greece",
            code: "0030"
        }, {
            brief: "GT",
            country: "Guatemala",
            code: "00502"
        }, {
            brief: "GU",
            country: "Guam",
            code: "001"
        }, {
            brief: "GW",
            country: "Guinea-Bissau",
            code: "00245"
        }, {
            brief: "GY",
            country: "Guyana",
            code: "00592"
        }],
        H: [{
            brief: "HK",
            country: "Hong Kong",
            code: "00852"
        }, {
            brief: "HN",
            country: "Honduras",
            code: "00504"
        }, {
            brief: "HT",
            country: "Haiti",
            code: "00509"
        }, {
            brief: "HU",
            country: "Hungary",
            code: "0036"
        }],
        I: [{
            brief: "ID",
            country: "Indonesia",
            code: "0062"
        }, {
            brief: "IE",
            country: "Ireland",
            code: "00353"
        }, {
            brief: "IL",
            country: "Israel",
            code: "00972"
        }, {
            brief: "IM",
            country: "Isle Of Man",
            code: "0044"
        }, {
            brief: "IN",
            country: "India",
            code: "0091"
        }, {
            brief: "IQ",
            country: "Iraq",
            code: "00964"
        }, {
            brief: "IR",
            country: "Iran",
            code: "0098"
        }, {
            brief: "IS",
            country: "Iceland",
            code: "00354"
        }, {
            brief: "IT",
            country: "Italy",
            code: "0039"
        }],
        J: [{
            brief: "JE",
            country: "Jersey",
            code: "0044"
        }, {
            brief: "JM",
            country: "Jamaica",
            code: "001"
        }, {
            brief: "JO",
            country: "Jordan",
            code: "00962"
        }, {
            brief: "JP",
            country: "Japan",
            code: "0081"
        }],
        K: [{
            brief: "KE",
            country: "Kenya",
            code: "00254"
        }, {
            brief: "KG",
            country: "Kyrgyzstan",
            code: "00996"
        }, {
            brief: "KI",
            country: "Kiribati",
            code: "00686"
        }, {
            brief: "KW",
            country: "Kuwait",
            code: "00965"
        }, {
            brief: "KZ",
            country: "Kazakhstan",
            code: "007"
        }],
        L: [{
            brief: "LA",
            country: "Laos",
            code: "00856"
        }, {
            brief: "LB",
            country: "Lebanon",
            code: "00961"
        }, {
            brief: "LI",
            country: "Liechtenstein",
            code: "00423"
        }, {
            brief: "LR",
            country: "Liberia",
            code: "00231"
        }, {
            brief: "LS",
            country: "Lesotho",
            code: "00266"
        }, {
            brief: "LT",
            country: "Lithuania",
            code: "00370"
        }, {
            brief: "LU",
            country: "Luxembourg",
            code: "00352"
        }, {
            brief: "LV",
            country: "Latvia",
            code: "00371"
        }, {
            brief: "LY",
            country: "Libya",
            code: "00218"
        }],
        M: [{
            brief: "FM",
            country: "Micronesia",
            code: "00691"
        }, {
            brief: "MA",
            country: "Morocco",
            code: "00212"
        }, {
            brief: "MC",
            country: "Monaco",
            code: "00377"
        }, {
            brief: "MD",
            country: "Moldova",
            code: "00373"
        }, {
            brief: "ME",
            country: "Montenegro",
            code: "00382"
        }, {
            brief: "MG",
            country: "Madagascar",
            code: "00261"
        }, {
            brief: "MH",
            country: "Marshall Islands",
            code: "00692"
        }, {
            brief: "MK",
            country: "Macedonia",
            code: "00389"
        }, {
            brief: "ML",
            country: "Mali",
            code: "00223"
        }, {
            brief: "MM",
            country: "Myanmar",
            code: "0095"
        }, {
            brief: "MN",
            country: "Mongolia",
            code: "00976"
        }, {
            brief: "MO",
            country: "Macao",
            code: "00853"
        }, {
            brief: "MQ",
            country: "Martinique",
            code: "00596"
        }, {
            brief: "MR",
            country: "Mauritania",
            code: "00222"
        }, {
            brief: "MS",
            country: "Montserrat",
            code: "001"
        }, {
            brief: "MT",
            country: "Malta",
            code: "00356"
        }, {
            brief: "MU",
            country: "Mauritius",
            code: "00230"
        }, {
            brief: "MV",
            country: "Maldives",
            code: "00960"
        }, {
            brief: "MW",
            country: "Malawi",
            code: "00265"
        }, {
            brief: "MX",
            country: "Mexico",
            code: "0052"
        }, {
            brief: "MY",
            country: "Malaysia",
            code: "0060"
        }, {
            brief: "MZ",
            country: "Mozambique",
            code: "00258"
        }, {
            brief: "YT",
            country: "Mayotte",
            code: "00262"
        }],
        N: [{
            brief: "KP",
            country: "North Korea",
            code: "00850"
        }, {
            brief: "MP",
            country: "Northern Mariana Islands",
            code: "001"
        }, {
            brief: "NA",
            country: "Namibia",
            code: "00264"
        }, {
            brief: "NC",
            country: "New Caledonia",
            code: "00687"
        }, {
            brief: "NE",
            country: "Niger",
            code: "00227"
        }, {
            brief: "NF",
            country: "Norfolk Island",
            code: "00672"
        }, {
            brief: "NG",
            country: "Nigeria",
            code: "00234"
        }, {
            brief: "NI",
            country: "Nicaragua",
            code: "00505"
        }, {
            brief: "NL",
            country: "Netherlands",
            code: "0031"
        }, {
            brief: "NO",
            country: "Norway",
            code: "0047"
        }, {
            brief: "NP",
            country: "Nepal",
            code: "00977"
        }, {
            brief: "NR",
            country: "Nauru",
            code: "00674"
        }, {
            brief: "NU",
            country: "Niue",
            code: "00683"
        }, {
            brief: "NZ",
            country: "New Zealand",
            code: "0064"
        }],
        O: [{
            brief: "OM",
            country: "Oman",
            code: "00968"
        }],
        P: [{
            brief: "PA",
            country: "Panama",
            code: "00507"
        }, {
            brief: "PE",
            country: "Peru",
            code: "0051"
        }, {
            brief: "PG",
            country: "Papua New Guinea",
            code: "00675"
        }, {
            brief: "PH",
            country: "Philippines",
            code: "0063"
        }, {
            brief: "PK",
            country: "Pakistan",
            code: "0092"
        }, {
            brief: "PL",
            country: "Poland",
            code: "0048"
        }, {
            brief: "PR",
            country: "Puerto Rico",
            code: "001"
        }, {
            brief: "PS",
            country: "Palestine",
            code: "00970"
        }, {
            brief: "PT",
            country: "Portugal",
            code: "00351"
        }, {
            brief: "PW",
            country: "Palau",
            code: "00680"
        }, {
            brief: "PY",
            country: "Paraguay",
            code: "00595"
        }],
        Q: [{
            brief: "QA",
            country: "Qatar",
            code: "00974"
        }],
        R: [{
            brief: "RE",
            country: "Reunion",
            code: "00262"
        }, {
            brief: "RO",
            country: "Romania",
            code: "0040"
        }, {
            brief: "RU",
            country: "Russia",
            code: "007"
        }, {
            brief: "RW",
            country: "Rwanda",
            code: "00250"
        }],
        S: [{
            brief: "BL",
            country: "Saint Barthélemy",
            code: "00590"
        }, {
            brief: "CH",
            country: "Switzerland",
            code: "0041"
        }, {
            brief: "ES",
            country: "Spain",
            code: "0034"
        }, {
            brief: "KN",
            country: "Saint Kitts And Nevis",
            code: "001"
        }, {
            brief: "KR",
            country: "South Korea",
            code: "0082"
        }, {
            brief: "LC",
            country: "Saint Lucia",
            code: "001"
        }, {
            brief: "LK",
            country: "Sri Lanka",
            code: "0094"
        }, {
            brief: "MF",
            country: "Saint Martin",
            code: "00590"
        }, {
            brief: "PM",
            country: "Saint Pierre And Miquelon",
            code: "00508"
        }, {
            brief: "RS",
            country: "Serbia",
            code: "00381"
        }, {
            brief: "SA",
            country: "Saudi Arabia",
            code: "00966"
        }, {
            brief: "SB",
            country: "Solomon Islands",
            code: "00677"
        }, {
            brief: "SC",
            country: "Seychelles",
            code: "00248"
        }, {
            brief: "SD",
            country: "Sudan",
            code: "00249"
        }, {
            brief: "SE",
            country: "Sweden",
            code: "0046"
        }, {
            brief: "SG",
            country: "Singapore",
            code: "0065"
        }, {
            brief: "SH",
            country: "Saint Helena",
            code: "00290"
        }, {
            brief: "SI",
            country: "Slovenia",
            code: "00386"
        }, {
            brief: "SJ",
            country: "Svalbard And Jan Mayen",
            code: "0047"
        }, {
            brief: "SK",
            country: "Slovakia",
            code: "00421"
        }, {
            brief: "SL",
            country: "Sierra Leone",
            code: "00232"
        }, {
            brief: "SM",
            country: "San Marino",
            code: "00378"
        }, {
            brief: "SN",
            country: "Senegal",
            code: "00221"
        }, {
            brief: "SO",
            country: "Somalia",
            code: "00252"
        }, {
            brief: "SR",
            country: "Suriname",
            code: "00597"
        }, {
            brief: "ST",
            country: "Sao Tome And Principe",
            code: "00239"
        }, {
            brief: "SX",
            country: "Sint Maarten (Dutch part)",
            code: "001"
        }, {
            brief: "SY",
            country: "Syria",
            code: "00963"
        }, {
            brief: "SZ",
            country: "Swaziland",
            code: "00268"
        }, {
            brief: "VC",
            country: "Saint Vincent And The Grenadines",
            code: "001"
        }, {
            brief: "WS",
            country: "Samoa",
            code: "00685"
        }, {
            brief: "ZA",
            country: "South Africa",
            code: "0027"
        }],
        T: [{
            brief: "CD",
            country: "The Democratic Republic Of Congo",
            code: "00243"
        }, {
            brief: "TC",
            country: "Turks And Caicos Islands",
            code: "001"
        }, {
            brief: "TG",
            country: "Togo",
            code: "00228"
        }, {
            brief: "TH",
            country: "Thailand",
            code: "0066"
        }, {
            brief: "TJ",
            country: "Tajikistan",
            code: "00992"
        }, {
            brief: "TK",
            country: "Tokelau",
            code: "00690"
        }, {
            brief: "TL",
            country: "Timor-Leste",
            code: "00670"
        }, {
            brief: "TM",
            country: "Turkmenistan",
            code: "00993"
        }, {
            brief: "TN",
            country: "Tunisia",
            code: "00216"
        }, {
            brief: "TO",
            country: "Tonga",
            code: "00676"
        }, {
            brief: "TR",
            country: "Turkey",
            code: "0090"
        }, {
            brief: "TT",
            country: "Trinidad and Tobago",
            code: "001"
        }, {
            brief: "TV",
            country: "Tuvalu",
            code: "00688"
        }, {
            brief: "TW",
            country: "Taiwan",
            code: "00886"
        }, {
            brief: "TZ",
            country: "Tanzania",
            code: "00255"
        }],
        U: [{
            brief: "AE",
            country: "United Arab Emirates",
            code: "00971"
        }, {
            brief: "GB",
            country: "United Kingdom",
            code: "0044"
        }, {
            brief: "UA",
            country: "Ukraine",
            code: "00380"
        }, {
            brief: "UG",
            country: "Uganda",
            code: "00256"
        }, {
            brief: "US",
            country: "United States",
            code: "001"
        }, {
            brief: "UY",
            country: "Uruguay",
            code: "00598"
        }, {
            brief: "UZ",
            country: "Uzbekistan",
            code: "00998"
        }, {
            brief: "VI",
            country: "U.S. Virgin Islands",
            code: "001"
        }],
        V: [{
            brief: "VA",
            country: "Vatican",
            code: "00379"
        }, {
            brief: "VE",
            country: "Venezuela",
            code: "0058"
        }, {
            brief: "VN",
            country: "Vietnam",
            code: "0084"
        }, {
            brief: "VU",
            country: "Vanuatu",
            code: "00678"
        }],
        W: [{
            brief: "EH",
            country: "Western Sahara",
            code: "00212"
        }, {
            brief: "WF",
            country: "Wallis And Futuna",
            code: "00681"
        }],
        Y: [{
            brief: "YE",
            country: "Yemen",
            code: "00967"
        }],
        Z: [{
            brief: "ZM",
            country: "Zambia",
            code: "00260"
        }, {
            brief: "ZW",
            country: "Zimbabwe",
            code: "00263"
        }]
    };

    function getAll(s, q) {
        var r = ["<div class='country-code'>"];
        var m, h;
        for (var j, o = 0; j = e[o++]; ) {
            m = d[j];
            if (s && (j in s)) {
                j = s[j]
            }
            if (m) {
                common = j;
                if(j == "usual"){
                   common = "常用";
                }
                r.push("<div class='container'><div class='head'>" + common + "</div>");
                r.push("<ul>");
                for (var g, l = 0; g = m[l++]; ) {
                    h = q ? (g.code + "").replace(/^0+/, function() {
                        return "+"
                    }) : g.code;
                    r.push("<li data-code='" + h + "' data-brief='" + g.brief + "'><span class='record-country'>" + g.country + "</span><span class='record-code'>" + h + "</span></li>")
                }
                r.push("</ul></div>")
            }
        }
        r.push("</div>");
        return r.join("")
    }
    function each(g) {
        var l;
        if (g) {
            for (var o, j = 0; o = e[j++]; ) {
                l = d[o];
                for (var m, h = 0; m = l[h]; h++) {
                    g(o, m, d[o], h)
                }
            }
        }
    }
    function getData() {
        return d
    }
    function getList() {
        return e
    }
    function initCY() {
        $('#cycode-container').html(CountryCode.getAll(null, 1))

        var $cycodeBox = $('#cycode-box');
        var $cycodeContainer = $('#cycode-container');
        var timer;
        var cycodeClickHandler = function(e) {
    		clearTimeout(timer);
    		timer = setTimeout(function() {
    			$cycodeContainer.toggle('show')
    		}, 200);
        };

        $cycodeBox.find('.cycode-selected').on('click', cycodeClickHandler)

        $cycodeBox.on('click', function(e) {
            e.stopPropagation();
        });

        $cycodeContainer.on('click', 'li', function(e) {
            var v = '+' + $(this).data('code');
            if($('#cycode')[0].tagName.toLowerCase() === 'input') $('#cycode').val(v);
            else $('#cycode').html(v);
            $cycodeContainer.fadeOut()
        })

        $(document).on('click', function(e) {
            if(!$cycodeContainer.is(':hidden')) $cycodeContainer.fadeOut()
        })
    }

    function selectCY(code) {
        var $li = $('#cycode-box').find('li[data-code="+'+ code +'"]')

        $li.trigger('click')
    }

    function getFormData($form){
        var out = {};
        var data = $form.serializeArray();
        //transform into simple data/value object
        for(var i = 0; i<data.length; i++){
            var record = data[i];
            out[record.name] = record.value;
        }
        return out;
    }
    
    window.CountryCode = {
    	abbrList: e,
    	codeMapList: d,
        getAll: getAll,
        each: each,
        getData: getData,
        getList: getList,
        init: initCY,
        selectCY: selectCY,
        getFormData: getFormData
    }
})();
