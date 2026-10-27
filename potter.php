<?php
    # Program: potter.php
    #    Date: 22-Jan-2026
    #  Author: gerry.walterscheid@gmail.com
    # Descrip: Trivia game for Harry Potter fans.

    session_start();
    header("Content-type: text/xml");

    # Web URL used pass data back to application.
    $url = "http://192.168.3.250/cisco/potter.php";

    # Used to adjust puzzle width to match current phone model.
    function getCiscoPhoneModel() {
        return $_SERVER['HTTP_X_CISCOIPPHONEMODELNAME'] ?? 'unknown';
	}

    # Initialize arrays containing trivia data.

    $house = array("Gryffindor", "Hufflepuff", "Ravenclaw", "Slytherin");

    $who = array(
        "Aberforth Dumbledore: Brother of Albus and Ariana. Owner of the Hog's Head tavern.:family-male",
        "Alastor (Mad-Eye) Moody: Retired Auror and member of the Order of the Phoenix. Impersonated by Barty Crouch Jr. in his scheme to enter Harry into the Triwizard Tournament.:Auror",
        "Albus Dumbledore: Transfiguration professor in Tom Riddle's time, and Hogwarts headmaster in Harry Potter's time. Founder of the Order of the Phoenix.:headmaster",
        "Alice and Frank Longbottom: Neville's parents. Aurors and members of the original Order of the Phoenix. Tortured into insanity by Bellatrix Lestrange.:Auror", 
        "Amos Diggory: Cedric's father. Employee of the Department for the Regulation and Control of Magical Creatures.:Ministry",
        "Amycus Carrow: Death Eater and brother of Alecto. Professor of Defence Against the Dark Arts for one year, and Deputy Headmaster of Hogwarts under Snape.:Death Eater",
        "Andromeda Tonks: Sister of Bellatrix Lestrange and Narcissa Malfoy, and the mother of Nymphadora. Disowned by her family for marrying Muggle-born Ted Tonks.:family-female",
        "Angelina Johnson: Gryffindor student two years above Harry. Quidditch Chaser and later team captain.:Quidditch-female",
        "Anthony Goldstein: Ravenclaw student in Harry's year. Member of Dumbledore's Army.:Ravenclaw",
        "Arabella Figg: Squib neighbour of the Dursleys. Member of the Order of the Phoenix.:Phoenix Order-female",
        "Aragog: Giant spider raised by Rubeus Hagrid and lived in the Forbidden Forest.:animal",
        "Argus Filch: Squib caretaker of Hogwarts.:notable",
        "Armando Dippet: Headmaster of Hogwarts when Tom Riddle first opened the Chamber of Secrets.:headmaster",
        "Arthur Weasley: Muggle-obsessed Ministry of Magic employee, and member of the Order of the Phoenix. Husband of Molly, father of Bill, Charlie, Percy, Fred, George, Ron, and Ginny.:Ministry",
        "Augusta Longbottom: Frank's mother and Neville's grandmother, who raises him after his parents are incapacitated.:family-female",
        "Aurora Sinistra: Astronomy professor at Hogwarts.:professor-female",
        "Bane: Centaur, not very wizard-friendly.:animal",
        "Barty Crouch Jr: Credited with facilitating the return of Lord Voldemort. Used Polyjuice Potion to impersonate Alastor Moody.:family-male",
        "Barty Crouch Sr: Head of the Department of International Magical Cooperation.:Ministry",
        "Bathilda Bagshot: Author of A History of Magic, and is a major source of information for Rita Skeeter's biography of Dumbledore.:author",
        "Beedle the Bard: Author of several wizarding fairy tales including The Tale of the Three Brothers.:author",
        "Bellatrix Lestrange: Cousin of Sirius Black. Death Eater who tortured Neville Longbottom's parents into insanity.:Death Eater",
        "Bill Weasley: Oldest son of Arthur and Molly, and Gringotts employee.:family-male",
        "Blaise Zabini: Slytherin student in Harry's year.:Slytherin",
        "Buckbeak: Hippogriff belonging at various times to Hagrid, Sirius Black and Harry Potter.:animal",
        "Cedric Diggory: Hufflepuff student and prefect two years above Harry. Quidditch Seeker and captain, and co-winner of the Triwizard Tournament.:Triwizard",
        "Charity Burbage: Professor of Muggle Studies at Hogwarts.:professor-female",
        "Charlie Weasley: Second son of Arthur and Molly. Member of the Order of the Phoenix. Works with dragons in Romania.:family-male",
        "Cho Chang: Ravenclaw Quidditch Seeker one year above Harry, and his first love interest. Member of Dumbledore's Army.:Ravenclaw",
        "Colin Creevey: Muggle-born Gryffindor student one year below Harry. Older brother of Dennis, and member of Dumbledore's Army.:Muggle",
        "Cormac McLaggen: Gryffindor student one year above Harry Potter. Quidditch Keeper and member of Horace Slughorn's Slug Club.:Quidditch-male",
        "Cornelius Fudge: Minister for Magic. Sacked after persistently denying Lord Voldemort's return.:Ministry",
        "Crookshanks: Intelligent cat belonging to Hermione Granger.:animal",
        "Cuthbert Binns: History of Magic professor.:ghost",
        "Dean Thomas: Gryffindor student in Harry's year. Member of Dumbledore's Army.:Gryffindor-male",
        "Dedalus Diggle: Member of the Order of the Phoenix who took the Dursleys into hiding.:Phoenix Order-male",
        "Demelza Robins: Gryffindor student and Quidditch Chaser.:Quidditch-female",
        "Dennis Creevey: Muggle-born Gryffindor student three years below Harry. Younger brother of Colin, and member of Dumbledore's Army.:Muggle",
        "Dobby: House-elf originally belonging to the Malfoy family until he is set free by Harry.:house-elf",
        "Dolores Umbridge: Senior Undersecretary to the Minister for Magic, Hogwarts High Inquisitor and temporary Headmistress of Hogwarts. She becomes Defence Against the Dark Arts professor.:Ministry",
        "Draco Malfoy: Slytherin student in Harry's year. Quidditch Seeker, prefect, and member of the Inquisitorial Squad.:Slytherin",
        "Dudley Dursley: Muggle son of Vernon and Petunia, first cousin of Harry Potter.:family-male",
        "Eloise Midgen: Gryffindor student that accidentally removed her nose trying to get rid of her acne. Known for her bad case of acne.:Gryffindor-female",
        "Emmeline Vance: Member of the Order of the Phoenix.:Phoenix Order-female",
        "Ernie Macmillan: Hufflepuff student in Harry's year. Prefect and member of Dumbledore's Army.:Hufflepuff",
        "Errol: Owl belonging to the Weasley family.:animal",
        "Fang: Hagrid's pet boarhound.:animal",
        "Fawkes: Phoenix belonging to Albus Dumbledore. Saved Harry Potter from the Basilisk inside the Chamber of Secrets.:animal",
        "Filius Flitwick: Head of Ravenclaw House and Charms professor at Hogwarts.:professor-male",
        "Firenze: Centaur and substitute Divination professor at Hogwarts during Harry's fifth year.:animal",
        "Fleur Delacour: Participant in the Triwizard Tournament as a representative of wizarding school Beauxbatons.:Triwizard",
        "Fluffy: Three-headed dog belonging to Hagrid and protector of the Philosopher's Stone.:animal",
        "Frank Bryce: Muggle gardener for the Riddle family. Killed by Lord Voldemort.:Muggle",
        "Fred Weasley: Son of Arthur and Molly Weasley and identical twin brother of George Weasley. Gryffindor Quidditch Beater and member of Dumbledore's Army, and co-owner of joke shop Weasleys' Wizard Wheezes.:Quidditch-male",
        "Gabrielle Delacour: Fleur's younger sister. Rescued by Harry during the Triwizard Tournament.:Triwizard",
        "Garrick Ollivander: Wandmaker and owner of a famous wand shop. Kidnapped by the Malfoy family for several months until freed by Harry, Ron, and Hermione.:notable",
        "George Weasley: Son of Arthur and Molly and identical twin brother of Fred. Gryffindor Quidditch Beater and member of Dumbledore's Army. Co-owner of Weasleys' Wizard Wheezes.:Quidditch-male",
        "Gilderoy Lockhart: Fraudulent celebrity author and Defence Against the Dark Arts teacher. Lost his memory after a memory charm backfired.:author",
        "Ginny Weasley: Only daughter and youngest child of Arthur and Molly. Gryffindor student one year below Harry, Quidditch Seeker and Chaser, and member of Dumbledore's Army.:Quidditch-female",
        "Godric Gryffindor: One of the four founders of Hogwarts. He was a very powerful wizard.:founder",
        "Graham Montague: Slytherin Quidditch Chaser who became trapped inside a Vanishing Cabinet for a day.:Quidditch-male",
        "Grawp: Giant and Hagrid's half-brother.:family-male",
        "Gregorovitch: Highly regarded Eastern European wandmaker.:notable",
        "Gregory Goyle: Slytherin student in Harry's year. Slytherin Quidditch Beater and member of the Inquisitorial Squad.:Quidditch-male",
        "Griselda Marchbanks: Governor of the Wizarding Examinations Authority which ran the O.W.L, N.E.W.T., and W.O.M.B.A.T. exams. Wizengamot elder.:notable",
        "Hannah Abbott: Hufflepuff student in Harry Potter's year. Prefect and member of Dumbledore's Army.:Hufflepuff",
        "Harry Potter: The main character of the series. Orphaned son of James and Lily. Gryffindor student at Hogwarts, and co-founder of Dumbledore's Army.:Gryffindor-male",
        "Hedwig: Harry Potter's pet female snowy owl. She was an eleventh birthday gift from Rubeus Hagrid.:animal",
        "The Grey Lady: Daughter of house founder Rowena Ravenclaw. Stole and hid her mother's diadem, and became Ravenclaw's house ghost after being killed by the Bloody Baron.:ghost",
        "Helga Hufflepuff: Founder of Hufflepuff House. Co-founder of Hogwarts School of Witchcraft and Wizardry.:founder",
        "Hermione Granger: Muggle-born Gryffindor student in Harry's year and one of his best friends. Co-founder of Dumbledore's Army.:Gryffindor-female",
        "Hokey: House-elf belonging to Hepzibah Smith.:house-elf",
        "Horace Slughorn: Former Hogwarts Potions professor and Head of Slytherin House, whose charges included Tom Riddle. Returned to Hogwarts to teach Potions in Harry's sixth year.:professor-male",
        "Igor Karkaroff: Reformed Death Eater. Headmaster of wizarding school Durmstrang.:headmaster",
        "James Potter: Harry's father and member of the Order of the Phoenix. Killed along with his wife Lily by Lord Voldemort prior to the start of the series.:family-male",
        "Justin Finch-Fletchley: Muggle-born Hufflepuff student in Harry's year. Member of Dumbledore's Army.:Muggle",
        "Katie Bell: Gryffindor Quidditch Chaser one year above Harry Potter. Member of Dumbledore's Army.:Quidditch-female",
        "Kendra Dumbledore: Wife of Percival. Mother of Albus, Aberforth, and Ariana.:family-female",
        "Kingsley Shacklebolt: Auror and member of the Order of the Phoenix.:Auror",
        "Kreacher: House-elf belonging to the Black family and later Harry Potter. Prefers to serve the pureblood line.:house-elf",
        "Lavender Brown: Gryffindor student in Harry's year and member of Dumbledore's Army.:Gryffindor-female",
        "Lee Jordan: Gryffindor student two years above Harry. Hogwarts Quidditch commentator and good friend of Fred and George Weasley.:Quidditch-male",
        "Lily Potter: Harry's mother and member of the Order of the Phoenix. Killed by Lord Voldemort.:family-female",
		"Lord Voldemort: The villain of the series. Murderer of Harry Potter's parents and many others in his quest for immortality and absolute power.:notable", 
        "Lucius Malfoy: Draco's father and an influential Death Eater. Governor of Hogwarts early in the series.:Death Eater", 
        "Ludo Bagman: Head of the Department of Magical Games and Sports within the Ministry of Magic.:Ministry", 
		"Luna Lovegood: Xenophilius's daughter and Ravenclaw student one year below Harry. Member of Dumbledore's Army.:Ravenclaw", 
        "Mafalda Hopkirk: Witch who works in the Ministry of Magic. Impersonated by Hermione Granger.:Ministry",
        "Magorian: A centaur.:animal",
        "Marge Dursley: Muggle sister of Vernon who floats out of the house and into the sky after Harry inflates her.:family-female",
        "Marietta Edgecombe: Ravenclaw student one year above Harry. Member of Dumbledore's Army who later betrays the group to Dolores Umbridge.:Ravenclaw",
        "Marvolo Gaunt: The pure-blood father of Merope and Morfin, and grandfather of Tom Marvolo Riddle.:family-male",
        "Mary Riddle: Muggle wife of Thomas, mother of Tom and grandmother of Lord Voldemort. Later killed by her grandson, Lord Voldemort.:family-female",
        "Merope Gaunt: Tom's mother who died in childbirth.:family-female",
        "Millicent Bulstrode: Slytherin student in Harry's year. Member of Dolores Umbridge's Inquisitorial Squad.:Slytherin",
        "Minerva McGonagall: Hogwarts Transfiguration professor, Head of Gryffindor House, Deputy Headmistress of Hogwarts, and member of the Order of the Phoenix.:professor-female",
        "Moaning Myrtle: Muggle-born Ravenclaw student during Tom Riddle's time at Hogwarts. Killed by the Basilisk in a girls' bathroom, which she continued to haunt after her death.:ghost",
        "Molly Weasley: Wife of Arthur and mother of Bill, Charlie, Percy, Fred, George, Ron, and Ginny. Member of the Order of the Phoenix.:family-female",
        "Morfin Gaunt: Marvolo's son and Merope's brother. Framed by his nephew Tom Riddle for Muggle killings, and died in Azkaban.:family-male",
        "Muggle Prime Minister: Name used by wizards when reffering to The Prime Minister of the United Kingdom. He is aware of the existence of the wizarding world.:Muggle",
        "Mundungus Fletcher: Common thief and shifty Order of the Phoenix member.:Phoenix Order-male",
        "Nagini: Lord Voldemort's massive pet snake that does his bidding. She is one of Voldemort's Horcruxes.:animal",
        "Narcissa Malfoy: Lucius' wife and Draco's mother. Sister of Bellatrix Lestrange and Andromeda Tonks.:family-female",
        "Nearly Headless Nick: Gryffindor house ghost. Full name is Sir Nicholas de Mimsy-Porpington.:ghost",
        "Neville Longbottom: Gryffindor student in Harry's year. Member of Dumbledore's Army.:Gryffindor-male",
        "Nicolas Flamel: Creator and owner of the Philosopher's Stone.:notable",
        "Norbert: A baby dragon illegally owned by Hagrid who is relocated to a reserve in Romania by friends of Ron's older brother Charlie Weasley.:animal",
        "Nymphadora Tonks: Ted and Andromeda's daughter. Auror and member of the Order of the Phoenix.:Auror",
        "Oliver Wood: Gryffindor Quidditch Keeper and captain four years above Harry.:Quidditch-male",
        "Olympe Maxime: Half-giantess. Headmistress of Beauxbatons.:headmaster",
        "Padma Patil: Ravenclaw student in Harry's year and Parvati's identical twin sister. Member of Dumbledore's Army.:Ravenclaw",
        "Pansy Parkinson: Slytherin student in Harry's year. Prefect and member of the Inquisitorial Squad.:Slytherin",
        "Parvati Patil: Gryffindor student in Harry's year and Padma's identical twin sister. Member of Dumbledore's Army.:Gryffindor-female",
        "Peeves: Hogwarts poltergeist, a mischievous magical being.:ghost",
        "Penelope Clearwater: Ravenclaw prefect and girlfriend of Percy Weasley.:Ravenclaw",
        "Percival Dumbledore: Husband of Kendra, father of Albus, Aberforth, and Ariana.:family-male",
        "Percy Weasley: Third son of Arthur and Molly. Gryffindor prefect and Head Boy, then Ministry of Magic employee, during which he becomes estranged from his family.:Ministry",
        "Peter Pettigrew: Death Eater and former school friend of James Potter, Sirius Black and Remus Lupin. Betrays Harry's parents James and Lily Potter to Voldemort.:Death Eater",
        "Petunia Dursley: Harry's aunt, and his mother Lily's sister. Vernon's wife and Dudley's mother.:family-female",
        "Phineas Nigellus Black: Great-great-grandfather of Sirius and former Hogwarts headmaster. His painting hangs in the office and assists the current headmaster.:painting",
        "Pigwidgeon: A tiny mischievous owl belonging to Ron Weasley. Called \"Pig\" for short.:animal",
        "Pius Thicknesse: Minister for Magic while under the Imperius Curse. Replaced by Kingsley Shacklebolt.:Ministry",
        "Pomona Sprout: Hogwarts Herbology professor and Head of Hufflepuff House.:professor-female",
        "Poppy Pomfrey: Hogwarts school nurse.:professor-female",
        "Quirinus Quirrell: Defence Against the Dark Arts professor in Harry Potter's first year. Possessed by Lord Voldemort.:professor-male",
        "Reginald Cattermole: Employee of the Magical Maintenance Department for the Ministry of Magic. Impersonated by Ron Weasley.:Ministry",
        "Remus Lupin: Lycanthropic Gryffindor student before Harry's time who befriended Sirius Black and James Potter. Professor of Defence Against the Dark Arts in Harry's third year.:professor-male",
        "Rita Skeeter: Reporter and tabloid journalist for the Daily Prophet.:author",
        "Rolanda Hooch: Hogwarts flying instructor and Quidditch referee.:professor-female",
        "Romilda Vane: Gryffindor student who unsuccessfully tries to romance Harry.:Gryffindor-female",
        "Ron Weasley: Youngest son of Arthur and Molly who is best friends with Harry Potter and Hermione Granger. Gryffindor Quidditch Keeper, prefect, and co-founder of Dumbledore's Army.:Quidditch-male",
        "Ronan: A centaur living in the Forbidden Forest.:animal",
        "Rowena Ravenclaw: One of the four founders of Hogwarts School of Witchcraft and Wizardry, and founder of the Ravenclaw house.:founder",
        "Rubeus Hagrid: Half-giant Hogwarts gamekeeper, and Care of Magical Creatures professor starting in Harry's third year. Member of the Order of the Phoenix.:professor-male",
        "Rufus Scrimgeour: Head of the Auror Office who replaces Cornelius Fudge as Minister for Magic.:Ministry",
        "Salazar Slytherin: One of the four founders of Hogwarts School of Witchcraft and Wizardry, and founder of the Slytherin house.:founder",
        "Scabbers: Ron Weasley's pet rat in the first three stories who is revealed to be Peter Pettigrew in animal form.:animal",
        "Seamus Finnigan: Gryffindor student in Harry's year. Member of Dumbledore's Army.:Gryffindor-male",
        "Septima Vector: Arithmancy professor at Hogwarts.:professor-female",
        "Severus Snape: Potions and later Defence Against the Dark Arts professor at Hogwarts. Head of Slytherin House, and member of both the Death Eaters and the Order of the Phoenix as a double agent for Dumbledore.:professor-male",
        "Silvanus Kettleburn: Care of Magical Creatures teacher until Harry's third year.:professor-male",
        "Sir Cadogan: Armored and somewhat mad knight occupying a painting in Hogwarts.:painting",
        "Sirius Black: Harry's godfather who was a close friend of Harry's father James. Escapee from Azkaban prison and member of the Order of the Phoenix.:family-male",
        "Stan Shunpike: Conductor of the triple-decker Knight Bus. Jailed in Azkaban on suspicions of being a Death Eater.:notable",
        "Sturgis Podmore: Member of the Order of the Phoenix.:Phoenix Order-male",
        "Susan Bones: Hufflepuff student in Harry's year. Member of Dumbledore's Army.:Hufflepuff",
        "Sybill Trelawney: Hogwarts Divination professor. Predicted the prophecy that prompted Lord Voldemort to go after the Potters.:professor-female",
        "Ted Tonks: Andromeda's Muggle-born husband, and the father of Nymphadora.:Muggle",
        "Terry Boot: Ravenclaw student in Harry's year. Member of Dumbledore's Army.:Ravenclaw",
        "The Bloody Baron: Slytherin House ghost. Suitor of Helena Ravenclaw before killing her in a fit of blind rage, then commits suicide in remorse.:ghost",
        "The Fat Friar: Hufflepuff House ghost.:ghost",
        "The Fat Lady: Witch in the painting concealing the entrance to the Gryffindor common room.:painting",
        "Theodore Nott: Slytherin student in the same year as Harry Potter, and son of a Death Eater.:Slytherin",
        "Thomas Marvolo Riddle: Slytherin student who became Lord Voldemort.:Slytherin",
        "Tom Riddle Sr.: Muggle son of Thomas and Mary, husband of Merope Gaunt and father of Lord Voldemort. Later killed by his son, Lord Voldemort.:family-male",
        "Trevor: Neville Longbottom's perpetually-misplaced pet toad.:animal",
        "Vernon Dursley: Harry Potter's Muggle uncle. Petunia's husband and Dudley's father.:family-male",
        "Viktor Krum: Bulgarian Quidditch Seeker and Durmstrang student who participated in the Triwizard Tournament.:Triwizard",
        "Vincent Crabbe: Slytherin Quidditch Beater, member of the Inquisitorial Squad and the son of a Death Eater.:Slytherin",
        "Walden Macnair: Death Eater and Committee of Disposal of Dangerous Creatures' executioner.:Death Eater",
        "Wilhelmina Grubbly-Plank: Substitute Care of Magical Creatures professor during Harry's fourth and fifth years.:professor-female",
        "Wilkie Twycross: Hogwarts Apparition instructor who works in the Department of Magical Transportation.:professor-male",
        "Winky: A female house-elf who belonged to Barty Crouch Sr until he sacked her, then worked in the Hogwarts kitchen.:house-elf",
        "Xenophilius Lovegood: Editor of tabloid magazine The Quibbler.:author",
        "Zacharias Smith: Hufflepuff Quidditch Chaser in Harry's year. Member of Dumbledore's Army.:Quidditch-male");

    $what = array(
        "A History of Magic: A book by Bathilda Bagshot.:object",
        "Anti-Cheating Quill: Detects and prevents deception during exams.:object",
        "Bubotuber: Magical plant used in potion-making.:object",
        "Charmed Compass: Magical object that always points to the user's desired location.:object",
        "Crystal Goblet: Cup with magical properties, used in potions.:object",
        "Deathly Hallows: A group of three objects known for having unique magical effects.:object",
        "Deluminator: Absorbs and releases light, and can locate a person's whereabouts.:object",
        "Dumbledore's Army Coin: Used to communicate between members of this group.:object",
        "Dumbledore's Pensieve: Basin used to review and explore memories.:object",
        "Elder Wand: One of the Deathly Hallows, a magical object being more powerful than all the others.:object",
        "Enchanted Quill: Enables magical writing abilities.:object",
        "Extendable Bridge: Magical pathway used to reach distant places.:object",
        "Extendable Ears: Magical devices for eavesdropping from a distance.:object",
        "Fantastic Beasts and where to Find Them: A book about magical creatures.:object",
        "Firebolt: High-quality broomstick used in Quidditch.:object",
        "Firewhiskey: Wizarding alcoholic beverage with a fire-breathing effect.:object",
        "Fizzing Pumpkin Juice: Popular wizarding beverage.:object",
        "Fizzing Whizzbees: Flying sweets that create a pleasant sensation.:object",
        "Floo Network: Magical network of fireplaces used for transportation.:object",
        "Floo Powder: A magical powder which provides instant transportation to another fireplace within the Network.:object",
        "Foe-Glass: Reflects the images of one's enemies or potential threats.:object",
        "Galleon: A gold coin used in the wizarding world.:object",
        "Gillyweed: Magical plant that, when eaten, allows humans to breathe underwater.:object",
        "Goblet of Fire: Used to select champions for the Triwizard Tournament.:object",
        "Godric Gryffindor's sword: Object once owned by one of the Hogwarts founders.:object",
        "Hogsmeade Postcard: Enchanted mail with moving images of the village.:object",
        "Hogwarts Express: A train that takes students to and from the school of magic.:object",
        "Hogwarts, A History: A book about a British school of Witches and Wizards.:object",
        "Horcrux: Any object used to store a piece of the soul of the wizard, making that wizard immortal.:object",
        "Howler: Enchanted letter which delivers a message with a loud voice, used to express anger in public.:object",
        "Invisibility Cloak: The third Deathly Hallows, making the wearer unseen.:object",
        "Knight Bus: A triple-decker vehicle used to assist stranded individuals of the wizarding community.:object",
        "Marauder's Map: Used to reveal the layout of Hogwarts and the location of everyone inside.:object",
        "Mirror of Erised: Shows the deepest desires of the heart to the viewer.:object",
        "Mokeskin pouch: A magical drawstring that nobody but the owner can open.:object",
        "Muggle Repelling Ward: Magical protection preventing entry into wizarding areas.:object",
        "Omnoculars: Magical device used to enhance Quidditch viewing.:object",
        "Owl Post: Magical service for delivering mail in the wizarding world.:object",
        "Parchment: Magical paper used for writing in the wizarding world.:object",
        "Pensieve: A magical stone receptacle that can reveal someone's memories from their past.:object",
        "Peruvian Darkness Powder: Creates a localized area absent of light when used.:object",
        "Philosopher's Stone: Alchemical creation that grants immortality and turns metal into gold.:object",
        "Polyjuice Potion: Mixture that allows the drinker to take on the appearance of another person.:object",
        "Probity Probe: A magical device that detects spells of concealment and hidden magical objects.:object",
        "Puking Pastilles: Sweets that induce vomiting, created by Fred and George Weasley.:object",
        "Quaffle: Ball used in Quidditch, thrown through the opponent's goalposts.:object",
        "Quick-Quotes Quill: Used to create sensationalized versions of speech.:object",
        "Quidditch through the Ages: A book about a popular sport in the wizarding world.:object",
        "Quill of Acceptance: Selects students worthy of attending Hogwarts.:object",
        "Remembrall: A little orb containing smoke that magically turns red when the owner has forgotten something.:object",
        "Resurrection Stone: Another Deathly Hallow, allows the holder to bring back the dead.:object",
        "Revealer: A magical red eraser that makes invisible ink appear.:object",
        "Secrecy Sensor: A magical object that vibrates when it detects concealment or lies.:object",
        "Self-Playing Harp: Enchanted instrument which plays music by itself.:object",
        "Shield Cloak: A robe that magically deflects minor hexes and curses.:object",
        "Shield Hat: A headpiece that magically deflects minor hexes and curses.:object",
        "Shrinking Solution: Potion that causes objects to become smaller.:object",
        "Skiving Snackbox: Conceals illnesses when consumed.:object",
        "Smart-Answer Quill: Automatically provides intelligent and accurate replies.:object",
        "Sneakoscope: Whistles and lights up to warn of potential danger or deception.:object",
        "Snidget Feather: Plume used in magical crafting.:object",
        "Snitch: Golden ball used in Quidditch. Catching it wins the game.:object",
        "Sonnets of a Sorcerer: A book that magically causes the reader to speak forever in limericks.:object",
        "Sorting Hat: Assigns new students to one of four Hogwarts Houses, by examining their abilities and personality.:object",
        "Spellotape: Magical adhesive used for repairing and joining things.:object",
        "The Tales of Beedle the Bard: A book of wizard folktales.:object",
        "Thestrals: Winged, skeletal horses visible only to those who have witnessed death.:object",
        "Time-Turner: A hourglass pendant which magically provides travel to the past.:object",
        "Triwizard Cup: Used to determine players in the Tournament, and serves as a Portkey.:object",
        "Vanishing Cabinet: Allows objects to be transported between two cabinets.:object",
        "Vanishing Spell: Magic used to make objects disappear.:object",
        "Veela Hair Ribbon: Used to enhance beauty.:object",
        "Veela Hairpin: Used to enhance magical abilities.:object",
        "Weasley family's clock: A clock that displays the information about each member of the Ron's family.:object",
        
        "Avis: Conjures a flock of birds from the caster's wand.:spell",
        "Rennervate: Awakens an unconscious person.:spell",
        "Accio: Summons an object to the caster.:spell",
        "Aguamenti: Produces a jet of water from the caster's wand.:spell",
        "Alohomora: Unlocks doors and other objects.:spell",
        "Apparate: A form of magical teleportation from one location to another.:spell",
        "Avada Kedavra: The Killing Curse, which causes instant death to the victim.:spell",
        "Colloportus: Seals a door so it cannot be opened.:spell",
        "Cruciatus Curse: Inflicts extreme pain on the victim, another of the Unforgivable Curses.:spell",
        "Crucio: Inflicts intense pain on the victim, one of the Unforgivable Curses.:spell",
        "Defodio: Digs through solid objects, such as walls or barriers.:spell",
        "Deletrius: Erases the image produced by the Priori Incantatem effect on wands.:spell",
        "Densaugeo: Causes the victim's teeth to grow rapidly.:spell",
        "Descendo: Causes objects to move downwards.:spell",
        "Diffindo: Cuts objects or materials.:spell",
        "Dissendium: Reveals the hidden entrance to Hogsmeade's secret passage.:spell",
        "Duro: Turns an object to stone.:spell",
        "Engorgio: Enlarges objects.:spell",
        "Ennervate: Awakens someone from unconsciousness.:spell",
        "Episkey: A healing spell used to treat minor injuries.:spell",
        "Epoximise: Binds objects together.:spell",
        "Evanesco: Makes objects vanish or disappear.:spell",
        "Expecto Patronum: Conjures a Patronus, a guardian that repels Dementors and other dark creatures.:spell",
        "Expelliarmus: Disarms an opponent by forcing them to release whatever they are holding.:spell",
        "Expulso: Causes objects to explode.:spell",
        "Extinguishing Spell: Puts out fires.:spell",
        "Fermaportus: Seals doors and gates.:spell",
        "Ferula: Creates a bandage and splint for treating injuries.:spell", 
        "Fidelius Charm: Hides a secret within a living person, making them the Secret-Keeper.:spell",
        "Flagrate: Conjures flames from the caster's wand, allowing them to draw in the air with fire.:spell",
        "Furnunculus: Causes a person to break out in boils.:spell",
        "Glisseo: Turns stairs into a slide.:spell",
        "Homorphus Charm: Reverts a werewolf back to human form.:spell",
        "Impedimenta: Slows down or obstructs the target.:spell",
        "Imperius Curse: Places the victim under the complete control of the caster, another Unforgivable Curse.:spell",
        "Imperturbable Charm: Makes an area soundproof and impervious to outside forces.:spell",
        "Impervius: Makes an object repel water or other substances.:spell",
        "Incarcerous: Conjures ropes or binds the target.:spell",
        "Incendio: Starts a fire or ignites an object.:spell",
        "Langlock: Glues the target's tongue to the roof of their mouth.:spell",
        "Languebrio: Reverses the effects of the Langlock spell, freeing the victim's tongue.:spell",
        "Leg-Locker Curse: Causes the victim's legs to become temporarily immobile.:spell",
        "Legilimency: The magical art of reading minds.:spell",
        "Legilimens: Allows the caster to read the thoughts and emotions of another person.:spell",
        "Levicorpus: Hangs the victim upside down by their ankle.:spell",
        "Liberacorpus: Counteracts the effects of the Levicorpus spell, which hangs the victim upside down.:spell",
        "Locomotor Mortis: Locks the target's legs together, rendering them immobile.:spell",
        "Locomotor Wibbly: Makes the target's legs wobble as if they are drunk.:spell",
        "Lumos Maxima: A more powerful version of the Lumos spell, creating a brighter light.:spell",
        "Lumos: Casts light from the tip of the caster's wand.:spell",
        "Melofors: Transforms a pumpkin into a giant fruit with a face.:spell",
        "Morsmordre: Conjures the Dark Mark, a symbol of Voldemort's presence.:spell",
        "Muffliato: Fills the ears of those nearby with a buzzing noise to ensure privacy.:spell",
        "Nox: Extinguishes the light produced by the Lumos spell.:spell",
        "Obliviate: Erases or modifies memories.:spell",
        "Orchideous: Conjures a bouquet of flowers from the caster's wand.:spell",
        "Petrificus Totalus: Renders the target completely immobile.:spell",
        "Polyjuice Potion: A complex potion that allows the drinker to take on the appearance of someone else.:spell",
        "Portkey: An enchanted object that transports a person to a specific location when touched.:spell",
        "Portus: Turns an object into a Portkey for teleportation.:spell",
        "Prior Incantato: Reveals the last spell cast by a wand.:spell",
        "Priori Incantatem: Occurs when two wands with the same core connect, revealing the spells previously cast by the wands.:spell",
        "Protego Maxima: A powerful shield charm that provides strong protection.:spell",
        "Protego: Creates a magical shield to deflect spells and objects.:spell",
        "Quietus: Counteracts the Sonorus spell, returning the caster's voice to normal volume.:spell",
        "Reducio: Shrinks objects.:spell",
        "Reducto: Breaks objects into smaller pieces or blasts them apart.:spell",
        "Reparo: Repairs broken objects.:spell",
        "Revelio: Reveals hidden objects or entrances.:spell",
        "Rictusempra: Causes the target to experience uncontrollable laughter.:spell",
        "Riddikulus: Used to transform a Boggart into something humorous, making it lose its fear factor.:spell",
        "Salvio Hexia: Provides protection against hexes.:spell",
        "Scourgify: Cleans objects or areas.:spell",
        "Sectumsempra: A spell that causes deep, slashing wounds on the target.:spell",
        "Serpensortia: Conjures a snake.:spell",
        "Silencing Charm: Counteracts the effects of the Muffliato spell, allowing the caster to hear conversations.:spell",
        "Silencio: Silences the target, preventing them from making noise.:spell",
        "Slugulus Eructo: Makes the victim vomit slugs.:spell",
        "Sonorus: Amplifies the caster's voice, making it louder.:spell",
        "Specialis Revelio: Reveals hidden magical properties of an object.:spell",
        "Stupefy: Stuns and temporarily incapacitates the target.:spell",
        "Taboo: Places a magical taboo on a word or name, allowing the caster to detect its usage.:spell",
        "Tarantallegra: Forces the target's legs to dance uncontrollably.:spell",
        "Tergeo: Cleans up spills and messes.:spell",
        "Vera Verto: Transforms an animal into a water goblet.:spell",
        "Waddiwasi: Unsticks an object from a surface.:spell",
        "Wingardium Leviosa: Levitates objects into the air.:spell");

    $where = array(
        "The Burrow: The Weasleys' home, located outside the village of Ottery St Catchpole. Has seven floors, quite dilapidated, managing to remain standing only by magic.:Home",
        "Godric's Hollow: Home to a magical community, including James Potter's family, and the long-dead Hogwarts founder Godric Gryffindor.:Home",
        "Little Hangleton: The place of origin of Voldemort's maternal and paternal ancestors, and was the place where he was restored to bodily form.:Home",
        "Number 4, Privet Drive is the Dursleys' home, where Harry lived with his aunt Petunia, uncle Vernon, and cousin Dudley since he was a baby, left at their doorstep.:Home",
        "Malfoy Manor: The home of the aristocratic family, Lucius, Narcissa, and Draco, and later Bellatrix Lestrange (sister of Narcissa).:Home",
        "Number 12, Grimmauld Place: Home of the Black family, an ancient and pure-blooded line of wizards. It contains the Black family tree on a wall tapestry, and an enchanted portrait of Walburga Black.:Home",
        "Shell Cottage: Home of Bill Weasley and Fleur Delacour after they get married in Deathly Hallows. It is located overlooking a beach outside the village of Teignmouth in Devon.:Home",
        "Spinner's End: A Muggle street, on which sits the home of Severus Snape. It is one of several streets of identical brick, located near a dirty river, the bank of which is strewn with litter.:Home",

        "Beauxbatons Academy: Housed in a glittering palace. Its students wear blue and grey silk uniforms, and follow a very strict system of protocol towards their professors.:School",
        "Durmstrang Institute: Located in Scandinavia. Their students wear heavy furs with blood-red robes. The school appears to be all boys from Russia and Bulgaria.:School",
        "Hogwarts: School of magic for students ages eleven to eighteen, located somewhere in Scotland. It has numerous charms and spells on and around it that make it impossible for Muggles to find it.:School",

        "Diagon Alley: To enter, one must go through the Leaky Cauldron to a rear courtyard and tap a brick in the wall, found by counting three up and two across, three times.:Diagon Alley",
        "The Daily Prophet: Office of the wizarding newspaper. The most widely-read daily newspaper in Britain's wizard community, with moving pictures. Its often a mouthpiece for the Ministry of Magic.:Diagon Alley",
        "Eeylops Owl Emporium: Shop with owls and supplies such as owl treats and cages. It is here that Rubeus Hagrid purchased Harry's snowy owl, Hedwig, as a birthday gift.:Diagon Alley",
        "Florean Fortescue's Ice Cream Parlour: Ice cream and other treats, which could be enjoyed at outdoor tables. Harry spent pleasant hours there working on homework assignments before his third year at Hogwarts.:Diagon Alley",
        "Flourish & Blotts: Bookstore with a great variety of magic books, including textbooks for Hogwarts courses and other books of general magical interest. In the back there is a corner devoted solely to divination.:Diagon Alley",
        "Gambol and Japes: Wizarding Joke Shop. Fred, George and Lee Jordan purchased Dr Filibuster's Fabulous Wet-Start, No-Heat Fireworks here.:Diagon Alley",
        "Gringotts Wizarding Bank: The only known bank of the wizarding world and it is operated primarily by goblins, near the intersection of Knockturn Alley and Diagon Alley,:Diagon Alley",
        "Knockturn Alley: A dark and seedy alleyway diagonal to Diagon Alley. It is frequently populated by Dark Wizards. Many of the shops in Knockturn Alley are devoted to the Dark Arts.:Diagon Alley",
        "The Leaky Cauldron: A dark, shabby pub and inn for wizards, offering food, drinks and rooms to rent, and serves as a gateway between the non-wizarding world and Diagon Alley.:Diagon Alley",
        "Madam Malkin's Robes for All Occasions: Clothing shop next to Flourish & Blotts. It sells robes and other clothing, including the standard Hogwarts-required plain black work robes, and dress robes.:Diagon Alley",
        "Magical Menagerie: A magical creature shop that in addition to selling magical creatures offers advice on animal care and health. The shop is very cramped, noisy and smelly.:Diagon Alley",
        "Ollivanders: Makers of Fine Wands since 382 BC. Within, there are countless narrow boxes piled neatly right up to the ceiling and a spindly-legged chair.:Diagon Alley",
        "Potage's Cauldron Shop: Sells different varieties and sizes of cauldrons, including copper, brass, pewter, silver, self-stirring, collapsible, and solid gold, according to a sign outside the shop.:Diagon Alley",
        "Quality Quidditch Supplies: Sells broomsticks and Quidditch-related items. The store windows often draw young customers to gaze longingly at the merchandise, like the Nimbus 2000 and the Firebolt broomsticks.:Diagon Alley",
        "Slug and Jiggers Apothecary: Sells scales, potions and potion ingredients. The shop is quite fascinating despite its very bad smell (a mixture of bad eggs and rotten cabbage).:Diagon Alley",
        "Wiseacre's Wizarding Equipment: Sells all sorts of equipment used in the wizard world. Harry buys his first telescope here.:Diagon Alley",
        "Twilfitt and Tatting's: A wizarding clothing shop where Narcissa Malfoy would shop there rather than Madam Malkin's due to the presence of Harry, Ron, and Hermione.:Diagon Alley",
        "Weasleys' Wizard Wheezes: A popular joke shop that started as a small school business created by Fred and George Weasley. It sells joke and trick items, useful novelties, and Defence Against the Dark Arts items.:Diagon Alley",

        "Borgin and Burkes: Antique shop in Diagon Alley, containing dangerous items such as a cursed opal necklace, or half of a vanishing cabinet set, used by Draco Malfoy to infiltrate Hogwarts.:Knockturn Alley",
        "The Coffin House: Sells paraphernalia related to the necromancy, the dark art of raising the dead.:Knockturn Alley",
        "Dystyl Phaelanges: A shop specializing in bones, fossils and fangs, as well as pieces of furniture made from bone. It has a large display of skeletons in the front window.:Knockturn Alley",
        "Fledermaus and Tanner: A shop that sells bats, located next-door to Trackleshanks Locksmith.:Knockturn Alley",
        "Markus Scarr's Indelible Tattoos: A wizarding parlour located by The White Wyvern pub and an undertaker's shop.:Knockturn Alley",
        "McHavelock's Wizarding Headgear: A wizarding shop specializing in hats and wigs. It was established in 1867 and is next to Borgin and Burkes, indicating a successful business.:Knockturn Alley",
        "Mr Mulpepper's Apothecary: A shop selling potion ingredients. Most wizards are unaware of its presence there outside of those of ill-repute. Another shop is directly next door to its competitor Slug & Jiggers Apothecary.:Knockturn Alley",
        "Noggin and Bonce: A shop in Knockturn Alley, specializing in shrunken heads. It has one window facing the street that displayed shrunken heads floating in a liquid.:Knockturn Alley",
        "Tallow and Hemp Toxic Tapers: A shop specializing in poisonous candles, located close to Trackleshanks Locksmith.:Knockturn Alley",
        "Trackleshanks Locksmith: A shop in which one can buy locks, and fit or replace keys, located close to the archway that leads to Horizont Alley.:Knockturn Alley",
        "The White Wyvern: A pub located up a set of stairs by Markus Scarr's Indelible Tattoos, next door to a pawnbrokers.:Knockturn Alley",

        "Hogsmeade: The only settlement in Britain inhabited solely by magical beings, and is located to the northwest of Hogwarts School of Witchcraft and Wizardry.:Hogsmeade",
        "The Three Broomsticks: A well known inn and pub located on High Street, known for its delicious butterbeer and its beautiful owner Madam Rosmerta. Its a favoured destination among Hogwarts students and staff.:Hogsmeade",
        "Zonko's Joke Shop: Has jokes and tricks that could fulfill even Fred and George's wildest dreams.:Hogsmeade",
        "Hogsmeade Station: The closest train stop to Hogwarts. The Hogwarts Express stops here after travelling from King's Cross.:Hogsmeade",
        "The Hog's Head: A pub which often attracts a more disreputable clientele than the Three Broomsticks. Most customers hide their faces to not be recognised. The barman and owner is Aberforth Dumbledore.:Hogsmeade",
        "Dervish & Banges: A shop that sells and repairs magical equipment, located near the end of the High Street.:Hogsmeade",
        "Gladrags Wizardwear: A clothing store full of quirky merchandise. Appears to specialise in strange and unusual socks, and is where Harry buys Dobby a selection of wacky socks.:Hogsmeade",
        "Scrivenshaft's Quill Shop: Sells a range of wizarding stationery like quills, ink, parchment, envelopes, seals, etc.:Hogsmeade",
        "Madam Puddifoot: A small teashop favourite among Hogwarts couples out on dates. On Valentine's Day the owner hires floating golden cherubs to throw pink confetti on visiting couples.:Hogsmeade",
        "Honeydukes Sweetshop: One of the most famous wizarding confectioneries in the world. It sells wizarding sweets of all descriptions, including Chocolate Frogs, Bertie Bott's Every Flavour Beans, etc.:Hogsmeade",
        "Post Office: Filled with at least two to three hundred owls, ranging from Great Grey Owls to tiny Scops, delivering  mail to people in the wizarding world.:Hogsmeade",
        "Shrieking Shack: Located on the outskirts of Hogsmeade, believed to be the most haunted building in Great Britain. Its Connected to Hogwarts by a secret tunnel underneath the Whomping Willow:Hogsmeade",

        "Azkaban: A prison where wizards who violate the laws of the British wizarding world are sent, located in the middle of the North Sea, and guarded by Dementors.:Government",
        "Ministry of Magic: Government of the Magical community of Britain. It is corrupt, incompetent or both, with high officials who are blind to actual events and dangers in the wizarding world.:Government",
        "Platform 9 and 3/4: The ride on the Hogwarts Express starts from King's Cross railway station, invisible to Muggle eyes and reached by walking through the barrier between platforms 9 and 10.:Government",
        "St. Mungo's: Hospital for Magical Maladies and Injuries, located in London. Established to treat magical maladies, injuries or illnesses endemic to the Wizarding World.:Government",

        "Chamber of Secrets: Created deep under the dungeons of Hogwarts Castle during the Medieval times by Salazar Slytherin, with an entrance in Moaning Myrtle's bathroom on the second floor.:Hogwarts-Underground",
        "Dungeons: Located under Hogwarts, and colder than the main castle. It contains the Potions classroom and Slytherin common room entrance. The dungeons are also used as places of detention.:Hogwarts-Underground",
        "Deathday Party Hall: One of the roomier dungeons at Hogwarts Castle. The room is accessible via the Dungeon Staircase. This is where Sir Nicholas de Mimsy-Porpington's five-hundredth Deathday Party occurs.:Hogwarts-Underground",
        "Potions Classroom: Located in the Dungeons, with walls lined with pickled animals in glass jars. In one corner stands a basin receiving ice-cold water poured from a gargoyle's mouth. The room is very cold, where students can see their own breath.:Hogwarts-Underground",
        "Potions Basement: Under the Potions classroom at Hogwarts Castle. It is accessible via a trapdoor and is used to store cauldrons, ingredients and phials.:Hogwarts-Underground",
        "Head of Slytherin's Office: A gloomy and dimly-lit room found in the school Dungeons, with shadowy walls lined with shelves of large glass jars filled with slimy, revolting things, floating in potions of varying colours.:Hogwarts-Underground",
        "Slytherin Common Room: Located behind a wall in the dungeons of Hogwarts. Entrance requires saying a Password to the wall. It is a low-ceilinged, dungeon-like room with greenish lamps and chairs.:Hogwarts-Underground",
        "Philosopher's Stone chambers: A series of rooms underneath Hogwarts which serve as the defences surrounding the Philosopher's Stone. There are seven chambers in total. which each contain an obstacle or task that guards the stone from theft.:Hogwarts-Underground",
        "Hufflepuff Common Room: A very cosy and welcoming place, with lots of yellow hangings, and fat armchairs, and little underground tunnels leading to the dormitories, all of which have perfectly round doors, like barrel tops.:Hogwarts-Underground",
        "Hogwarts Kitchen: Located directly under the Great Hall, down the staircase that leads to the Hufflepuff common room. Food placed on the tables magically appears in the Great Hall. Over 100 house-elves work here.:Hogwarts-Underground",
        "Boathouse: An underground harbour at Hogwarts where the boats were stored and docked after bringing the first years to the castle every year. This was located behind a curtin of ivy in the cliff face, at the end of a dark tunnel.:Hogwarts-Underground",

        "Entrance Hall: Located on the ground floor of Hogwarts, with a wide marble staircase opposite the oak doors. Double doors to the right led into the Great Hall.:Hogwarts-Ground",
        "Chamber of Reception: The Chamber of Reception is a little building before the Entrance Hall where Professor Minerva McGonagall makes the first year students wait before the Sorting ceremony and the Welcoming Feast.:Hogwarts-Ground",
        "Viaduct Courtyard: A quadrangle in Hogwarts. A popular hang-out spot for students of all Houses, this courtyard is where some students spend their spare time playing Gobstones.:Hogwarts-Ground",
        "Great Hall: The main gathering area in the school. Students eat their meals, receive daily owl posts, and have some special events. It has tall walls that reach up to the ceiling, enchanted to look like the sky above.:Hogwarts-Ground",
        "Transfiguration Classroom: Located on the ground floor around the Middle Courtyard. The classroom itself was big, surrounded by high windows, had four rows of three desks, and still had enough room for several cages and bookshelves, two chalkboards, and a desk.:Hogwarts-Ground",
        "Viaduct: A structure constructed out of stone, extending all the way down to the lake. It connects to a courtyard at one end and was connected to the left and right long towers.:Hogwarts-Ground",
        "Grand Staircase: A massive structure in Hogwarts, mainly used to access each floor of the castle, including the dungeons. There are hundreds of Portraits covering the walls in this tower.:Hogwarts-Ground",

        "Defence Against the Dark Arts Classroom: An iron chandelier hung from the ceiling, as well as a Dragon's skeleton. On one end of the classroom stood a projector that was activated by magic. Several desks and tables could be found in the classroom as well as some sets of large windows.:Hogwarts-First",
        "History of Magic Classroom: The subject was taught by Professor Cuthbert Binns, a ghost, who was widely regarded by almost all Hogwarts students as the most monotonous and boring teacher in existence.:Hogwarts-First",
        "Hospital Wing: Run by Poppy Pomfrey. Students who suffered mishaps during the school year were sent or brought here for treatment. It is well equipped to deal with all manner of magical and mundane injuries, from broken limbs to regrowing lost bones.:Hogwarts-First",
        "Gryffindor Head's Office: Positioned on a corridor which could be accessed by climbing the large staircase in Hogwarts' Entrance Hall. This office belonged to Professor McGonagall for many years.:Hogwarts-First",
        "Stone Bridge: Next to the Suspension Bridge. It connects the main First-floor corridor with the Tapestry Corridor in the Viaduct Entrance.:Hogwarts-First",
        "Tapestry Corridor: This pathway is located on the first floor of Hogwarts Castle. It connects the Viaduct Entrance to the main first floor. Its walls are covered in tapestries and, hung over the tapestries, portraits of wizards.:Hogwarts-First",
        "Storeroom: Located in the Tapestry Corridor, this was where Severus Snape stored his private supply of potions and potion ingredients. It was one of two known in the castle.:Hogwarts-First",
        "First-Floor Girls' Toilets: It was in this lavatory that Harry Potter and Ronald Weasley saved Hermione Granger from a mountain troll, marking the beginning of their friendship.:Hogwarts-First",

        "Second-floor Corridor: A passage on the second-floor of Hogwarts Castle. It was lined with bookcases with a small seating area and at one end, a tetraptych of Helena Ravenclaw.:Hogwarts-Third",
        "Moaning Myrtle's Bathroom: Situated on the second floor of Hogwarts Castle. It has been out of order ever since a student named Myrtle was killed there by Salazar Slytherin's Basilisk on the orders of Tom Riddle.:Hogwarts-Third",
        "Armoury: A corridor adjacent to the Trophy Room. There were a large amount of suits of armour on exhibition in this corridor.:Hogwarts-Third",
        "Charms Classroom: It hsa four long, large desks, located on both sides of the classroom. It has a large fireplace in the room, as well as several stacks of books, where Professor Flitwick lectured his pupils.:Hogwarts-Third",
        "Clock Tower Entrance: One of the three main entrances in Hogwarts Castle. It consists of a large open space at the base, with two stairwells going up towards the upper levels. A massive pendulum swung over this entrance.:Hogwarts-Third",
        "Library: Located on the third and fourth floors of Hogwarts and contains tens of thousands of books on thousands of shelves. This is where students can go to peruse or borrow books to supplement their studies.:Hogwarts-Third",
        "One-Eyed Witch Passage: A secret tunnel that led from Hogwarts to the cellar of Honeydukes Sweetshop in Hogsmeade. Harry Potter first learned of it from Fred and George Weasley when they gave him the Marauder's Map.:Hogwarts-Third",
        "Trophy Room: Where awards, trophies, cups, plates, shields, statues, and medals are kept in crystal glass displays. Prominently displayed were Hogwarts Awards for Services to the School.:Hogwarts-Third",
        "Third Floor Corridor: On the right side of the Castle. Was out of bounds during one school year because it was the access point to the Chambers where the Philosopher's Stone was being hidden.:Hogwarts-Third",

        "Restricted Section: An area in the fourth floor section of the Hogwarts Library closed off by a rope and only accessible to students with permission from a professor. These books typically discussed the Dark Arts.:Hogwarts-Fourth",
        "Disused classroom: Where the Mirror of Erised was kept for 4 months, and where Harry saw the image of himself and his deceased relatives, including his parents.:Hogwarts-Fourth",
        "Fourth-Floor Bathroom: Graham Montague ended up stuck in one of the toilets here after Disapparating out of the Vanishing Cabinet he was trapped in.:Hogwarts-Fourth",
        "Mirror Passage: A secret passage behind the mirror on the fourth floor of Hogwarts that leads from the castle to the town of Hogsmeade. The secret passage is shown on the Marauder's Map.:Hogwarts-Fourth",
        "Fourth-floor Corridor: A passage allowed access to a balcony and travel between the West Tower and Gryffindor Tower,:Hogwarts-Fourth",

        "Ravenclaw Head's Office: The office contains portraits, a desk, and sleeping quarters. This was where Sirius Black was held captive, awaiting the Dementor's Kiss. He was later rescued by Harry Potter and Hermione Granger, escaping on Buckbeak the Hippogriff.:Hogwarts-Seventh",
        "Room of Requirement: A secret room in Hogwarts that only appears when a person is in great need of it. The room transforms itself into whatever the witch or wizard needs it to be at that moment.Hogwarts-Seventh",
        "Hall of Hexes: A hall on the seventh floor of Hogwarts Castle, close to the Room of Requirement, and appears on the Marauder's Map.:Hogwarts-Seventh",
        "Arithmancy Classroom: Located on the seventh floor of Hogwarts Castle. It has number charts, a blackboard and large rows of tables for students to sit in.:Hogwarts-Seventh",
        "Fat Lady's Corridor: Contains the portrait of the Fat Lady that serves as the entrance to Gryffindor Tower. The corridor is at least one turn away from the Grand Staircase.:Hogwarts-Seventh",
        "Divination Classroom: It was located in the North Tower. It was accessible through a circular trapdoor and was described as looking like a cross between somebody's attic and an old-fashioned teashop.:Hogwarts-Seventh",

        "Astronomy Tower: The tallest tower at Hogwarts Castle, surrounded by a parapet and turret. It is where students studied the stars and planets through their telescopes at midnight.:Hogwarts-Tower",
        "Bell Towers: Two towers that rose over the main entrance to the Herbology Greenhouses. Between the two towers were a set of double wooden doors which led along the Ground Floor Corridor.:Hogwarts-Tower",
        "Clock Tower: At the Third Floor entrance there was a huge space, like an Entrance Hall with flights of wooden stairs at the right and left sides. The first landing was at the Fourth Floor level, where the clock's gears and face were.:Hogwarts-Tower",
        "Dark Tower: A small but high tower near the Transfiguration Courtyard at Hogwarts Castle. This tower seemed to be used as a prison. It had several prison cells, with the topmost being at the roof.:Hogwarts-Tower",
        "Dark Arts Tower: Among the largest towers of the Hogwarts Castle. It stood next to the Viaduct Entrance, overlooking the Suspension Bridge and the Training Grounds. It had a semi-circular shape.:Hogwarts-Tower",
        "Grand Staircase Tower: One of the many towers of Hogwarts Castle. It was one of the most prominent and recognisable features of the castle, dominating the skyline near the Great Hall and the Quad.:Hogwarts-Tower",
        "Gryffindor Tower: Located behind the portrait of the Fat Lady on the Seventh Floor of Hogwarts Castle. A Password was required to enter it, which was spoken to the portrait.:Hogwarts-Tower",
        "Headmaster's Tower: Located within this tower. To gain entrance, a password had to be given to a stone gargoyle, which would move aside at the correct password to reveal a spiral staircase with moving steps.:Hogwarts-Tower",
        "Hospital Tower: One of the many towers of Hogwarts Castle which had a semi-ovular shape. It was located on one side of The Quad and was at the end of the hospital corridor which connected the Clock Tower to the rest of the castle.:Hogwarts-Tower",
        "North Tower: One of the many towers in the castle. The tower was the location for Divination classes and the Divination teacher's office. The entrance consisted of a ladder leading through a trap door.:Hogwarts-Tower",
        "Ravenclaw Tower: Located on the west side of Hogwarts. The staircas leading up to the common room was presumably located on the fifth floor, and was the location of the Ravenclaw common room and dormitories.:Hogwarts-Tower",
        "Stone Bridge Tower: One of the four towers surrounding The Quad. It overlooked the Stone Bridge. The first floor landing of the tower went over here connecting the First-floor corridor to the Stone Bridge.:Hogwarts-Tower",
        "West Tower: The Owlery was located on the top of this tower. A tightly spiralling staircase led from the bottom of the tower on the seventh floor up to a door leading out onto the battlements.:Hogwarts-Tower",

        "Gamekeeper's Hut: Located on the edge of the Forbidden Forest. Rubeus Hagrid lives here during Harry Potter's time at Hogwarts,:Hogwarts-Grounds",
        "Forbidden Forest: Borders the edges of the Hogwarts. It is strictly off limits to students, except in the case of detention, or Care of Magical Creatures lessons that occasionally took place there.:Hogwarts-Grounds",
        "Greenhouses and Gardens: Herbology classes are held here, under Professor Sprout's supervision. One of these is restricted to students because of dangerous plants such as Venomous Tentaculas, Mandrakes, and others.:Hogwarts-Grounds",
        "Great Lake: A large body of water located to the south of the castle. It is about half a mile in diameter and the Hogwarts plumbing network drain into it. It is home to a giant squid and colony of Merpeople.:Hogwarts-Grounds",
        "Quidditch Pitch: Where each house's Quidditch teams practise and play games against each other. Each year there are six inter-house matches, along with numerous training sessions by each house team.:Hogwarts-Grounds",
        "Clock Tower Courtyard: A cloister on the base of the Clock Tower at Hogwarts. This is one of the older parts of the castle, and the ceiling and walls were dilapidated. It also leads to the Wooden Bridge.:Hogwarts-Grounds",
        "Wooden Bridge: Constructed of wood beams which extend to the floor of the ravine it crosses. The roof is sagging and appears thatched and tarred. This structure blends in with the natural environment surrounding it.:Hogwarts-Grounds",
        "Training Grounds: Flying classes are taught here by Madam Hooch. It is flat, with short-cut grassy areas near the Herbology greenhouses. It is overlooked by a large tower.:Hogwarts-Grounds");


    $state = $_SESSION['state'] ?? 0;   # Track current program state.
    $h = $_SESSION['h'] ?? 0;           # Player house.

    $option = [];
    $option[]= $_SESSION['opt1'] ?? 0;
    $option[]= $_SESSION['opt2'] ?? 0;
    $option[]= $_SESSION['opt3'] ?? 0;

    $select = $_SESSION['sel'] ?? 0;
    $points = $_SESSION['points'] ?? 0;

    $total = [];
    $total[] = $_SESSION['tot1'] ?? 0;
    $total[] = $_SESSION['tot2'] ?? 0;
    $total[] = $_SESSION['tot3'] ?? 0;
    $total[] = $_SESSION['tot4'] ?? 0;

    $lastCmd = $_SESSION['cmd'] ?? "";
    $desc = "";

    # Get SoftKey selection and determine which action to take.
    $cmd = $_GET['key'] ?? "";

    # Prompt the user for information based on the key pressed.
    switch($cmd) {
        case "prv" :
            # Don't decrement until displaying the current house.
            if (!isset($h))
                $h = 0;
            else
                $h = ($h + 3) % 4;

            $state = 0;
            $mesg = "Playing for $house[$h]?";
            break;

        case "nxt" :
            # Don't increment until displaying the current house.
            if (!isset($h))
                $h = 0;
            else
                $h = ($h +1) % 4;

            $state = 0;
            $mesg = "Playing for $house[$h]?";
            break;

        case "sel" :
            if (isset($h)) {
                $state = 1;
                $mesg = "Pick a category.";
            }
            else
                $mesg = "Please pick your house.";
            break;

        case "who" :
            $points = 5;

            # Select a random record, then determine its category.
            $size = count($who);

            # If less than 3 records in category, discard and start over.
            do  {
                # Each record should contain the name, description, and category.
                # If it doesn't, ie. is malformed, discard and get a new one.
                do  {
                    $record = mt_rand(0, $size - 1);
                    $data = explode(":", $who[$record]); 
                    }
                while (count($data) < 3);

                $category = $data[2];

                # Create a subset with matching records.
                $subset = [];
                $qty = 0;

                for ($i = 0; $i < $size; $i++) {
					$data = explode(":", $who[$i]);

                    if ($data[2] == $category)
                        $subset[$qty++]= $who[$i];
                    }
                }
            while (count($subset) < 3);
            break;

        case "what" :
            $points = 15;

            # Select a random record, then determine its category.
            $size = count($what);

            # If less than 3 records in category, discard and start over.
            do  {
                # Each record should contain the name, description, and category.
                # If it doesn't, ie. is malformed, discard and get a new one.
                do  {
                    $record = mt_rand(0, $size - 1);
                    $data = explode(":", $what[$record]); 
                    }
                while (count($data) < 3);

                $category = $data[2];

                # Create a subset with matching records.
                $subset = [];
                $qty = 0;

                for ($i = 0; $i < $size; $i++) {
                    $data = explode(":", $what[$i]);
                    if ($data[2] == $category)
                        $subset[$qty++]= $what[$i];
                    }
                }
            while (count($subset) < 3);
            break;

        case "where" :
            $points = 10;

            # Select a random record, then determine its category.
            $size = count($where);

            # If less than 3 records in category, discard and start over.
            do  {
                # Each record should contain the name, description, and category.
                # If it doesn't, ie. is malformed, discard and get a new one.
                do  {
                    $record = mt_rand(0, $size - 1);
                    $data = explode(":", $where[$record]); 
                    }
                while (count($data) < 3);

                $category = $data[2];

                # Create a subset with matching records.
                $subset = [];
                $qty = 0;

                for ($i = 0; $i < $size; $i++) {
                    $data = explode(":", $where[$i]);
                    if ($data[2] == $category)
                        $subset[$qty++]= $where[$i];
                    }
                }
            while (count($subset) < 3);
            break;

        case "ident" :
            $state = 3;
            $mesg = "Select your answer.";
            break;

        case "1" :
        case "2" :
        case "3" :
            if ($state == 1) {
                $mesg = "Pick a category.";
                break;
            }

            # Display the message for 3 seconds.
            header("Refresh:2");

            if ($select == $cmd - 1) {
                $total[$h] += $points;
                $mesg = "$points pts to $house[$h]!";
            }
            else {
                $total[$h] -= $points;

                # If score becomes negative, give points to another house.
                if ($total[$h] < 0) {
                    $total[$h] = 0;

                    $h2 = ($h + mt_rand(1,3)) % 4;
                    $total[$h2] += $points ;
                }

                $mesg = "$points pts from $house[$h]!";
            }
            $state = 1;
            break;

        case "menu" :
            $state = 1;
            $mesg = "Pick a category.";
            break;

        default :
            $mesg = "Pick your house.";
    }

    # Build query with subset data collected.
    switch($cmd) {
        case "who" :
        case "what" :
        case "where" :
            # Get 3 different options, then select one for the Q & A.
            $size = count($subset);

            # Keep track of the option indexes.
            $option[0] = mt_rand(0, $size - 1);
            $option[1] = ($option[0] + 1) % $size;
            $option[2] = ($option[1] + 1) % $size;

            # Select a random option and save its description..
            $select = mt_rand(0,2);
            $data = explode(":", $subset[$option[$select]]);
            $desc = substr($data[1],1);

            # Replace option indexes with the items they point to.
            for ($i = 0; $i < 3; $i++) {
                $data = explode(":", $subset[$option[$i]]);
                $option[$i]= $data[0];
            }

            $state = 2;
            $mesg = "Press next to identify.";
            break;
    }


    # Replace special characters with its HTML equivalents. Update this as needed.
    for ($i = 0; $i < 3; $i++) 
        $option[$i] = str_replace("&","&amp;",$option[$i]);   # ampersand

    $desc = str_replace("&","&amp;",$desc);   # ampersand


    # Get Cisco IP Phone model, to adjust for display differences.
    $model = getCiscoPhoneModel();

    # Update the phone display.
    switch($state) {
        case 0 : 
            echo "<CiscoIPPhoneText>\n";
            echo "  <Title>Potter Trivia</Title>\n";
            echo "  <Text>";
            echo "Your triumphs will earn your house points, failures will lose them. ";
            echo "The house with the most points will be awarded the house cup.";
            echo "  </Text>\n";

            if (isset($h)) {
                echo "  <SoftKeyItem>\n";
                echo "    <Name>Prev</Name>\n";
                echo "    <URL>$url?key=prv</URL>\n";
                echo "    <Position>1</Position>\n";
                echo "  </SoftKeyItem>\n"; 
            }
            
            echo "  <SoftKeyItem>\n";
            echo "    <Name>Next</Name>\n";
            echo "    <URL>$url?key=nxt</URL>\n";
            echo "    <Position>2</Position>\n";
            echo "  </SoftKeyItem>\n";
            
            if (isset($h)) {
                echo "  <SoftKeyItem>\n";
                echo "    <Name>Select</Name>\n";
                echo "    <URL>$url?key=sel</URL>\n";
                echo "    <Position>3</Position>\n";
                echo "  </SoftKeyItem>\n";
            }            

            echo "  <SoftKeyItem>\n";
            echo "    <Name>Exit</Name>\n";
            echo "    <URL>SoftKey:Exit</URL>\n";
            echo "    <Position>4</Position>\n";
            echo "  </SoftKeyItem>\n";

            break;

        case 1 : 
            echo "<CiscoIPPhoneText>\n";
            echo "  <Title>Potter Trivia - $house[$h]</Title>\n";
            echo "  <Text>";

            if ($model == "CP-7911G") {
                echo "                     H o u s e    P o i n t s\n";
                printf("  Gryfindor: %03d    Ravenclaw: %03d\n", $total[0], $total[2]);
                printf("Hufflepuff: %03d       Slytherin: %03d\n", $total[1], $total[3]); }
            else {
                echo "                H o u s e    P o i n t s\n";
                printf("     Gryfindor: %03d    Ravenclaw: %03d\n", $total[0], $total[2]);
                printf("     Hufflepuff: %03d       Slytherin: %03d\n", $total[1], $total[3]); }

            echo "  </Text>\n";

            echo "  <SoftKeyItem>\n";
            echo "    <Name>Who</Name>\n";
            echo "    <URL>$url?key=who</URL>\n";
            echo "    <Position>1</Position>\n";
            echo "  </SoftKeyItem>\n";
            
            echo "  <SoftKeyItem>\n";
            echo "    <Name>What</Name>\n";
            echo "    <URL>$url?key=what</URL>\n";
            echo "    <Position>2</Position>\n";
            echo "  </SoftKeyItem>\n";
            
            echo "  <SoftKeyItem>\n";
            echo "    <Name>Where</Name>\n";
            echo "    <URL>$url?key=where</URL>\n";
            echo "    <Position>3</Position>\n";
            echo "  </SoftKeyItem>\n";

            echo "  <SoftKeyItem>\n";
            echo "    <Name>Exit</Name>\n";
            echo "    <URL>SoftKey:Exit</URL>\n";
            echo "    <Position>4</Position>\n";
            echo "  </SoftKeyItem>\n";

            break;

        case 2 : 
            echo "<CiscoIPPhoneText>\n";
            echo "  <Title>Potter Trivia - $house[$h]</Title>\n";
            echo "  <Text>";
            echo $desc;
            echo "  </Text>\n";

            echo "  <SoftKeyItem>\n";
            echo "    <Name>Next</Name>\n";
            echo "    <URL>$url?key=ident</URL>\n";
            echo "    <Position>1</Position>\n";
            echo "  </SoftKeyItem>\n";
            
            echo "  <SoftKeyItem>\n";
            echo "    <Name>Cancel</Name>\n";
            echo "    <URL>$url?key=menu</URL>\n";
            echo "    <Position>4</Position>\n";
            echo "  </SoftKeyItem>\n";

            break;

        case 3 : 
            echo "<CiscoIPPhoneText>\n";
            echo "  <Title>Potter Trivia - $house[$h]</Title>\n";
            echo "  <Text>";
            echo "1. $option[0]\n";
            echo "2. $option[1]\n";
            echo "3. $option[2]\n";
            echo "  </Text>\n";

            echo "  <SoftKeyItem>\n";
            echo "    <Name>1</Name>\n";
            echo "    <URL>$url?key=1</URL>\n";
            echo "    <Position>1</Position>\n";
            echo "  </SoftKeyItem>\n";
            
            echo "  <SoftKeyItem>\n";
            echo "    <Name>2</Name>\n";
            echo "    <URL>$url?key=2</URL>\n";
            echo "    <Position>2</Position>\n";
            echo "  </SoftKeyItem>\n";
            
            echo "  <SoftKeyItem>\n";
            echo "    <Name>3</Name>\n";
            echo "    <URL>$url?key=3</URL>\n";
            echo "    <Position>3</Position>\n";
            echo "  </SoftKeyItem>\n";

            break;

        case 4 : 
            echo "<CiscoIPPhoneText>\n";
            echo "  <Title>Potter Trivia - $house[$h]</Title>\n";
            echo "  <Text>";
            echo "Score:\n";
            echo "  $house[$h] = $total[$h] points";

            echo "  <SoftKeyItem>\n";
            echo "    <Name>Next</Name>\n";
            echo "    <URL>$url?key=menu</URL>\n";
            echo "    <Position>1</Position>\n";
            echo "  </SoftKeyItem>\n";
            
            echo "  <SoftKeyItem>\n";
            echo "    <Name>Exit</Name>\n";
            echo "    <URL>SoftKey:Exit</URL>\n";
            echo "    <Position>4</Position>\n";
            echo "  </SoftKeyItem>\n";

            break;
    }

    echo "  <Prompt>";
    echo $mesg;
    echo "  </Prompt>\n";

    echo "</CiscoIPPhoneText>";

    $_SESSION['state'] = $state;
    $_SESSION['h'] = $h;
    $_SESSION['opt1'] = $option[0];
    $_SESSION['opt2'] = $option[1];
    $_SESSION['opt3'] = $option[2];

    $_SESSION['sel'] = $select;
    $_SESSION['points'] = $points;

    $_SESSION['tot1'] = $total[0];
    $_SESSION['tot2'] = $total[1];
    $_SESSION['tot3'] = $total[2];
    $_SESSION['tot4'] = $total[3];
?>

