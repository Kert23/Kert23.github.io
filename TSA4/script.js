const dishes = {
    adobo: {
        name: "Adobo",
        info: "Category: Filipino | Price: ₱550 | Location: Manila",
        description: "Adobo is widely considered the unofficial national dish of the Philippines, revered for its rich, savory, and tangy flavor profile. The term 'adobo' is derived from the Spanish word 'adobar,' which means 'to marinate.' Although the name came from the Spanish colonizers, the cooking method pre-dates their arrival. Traditionally, adobo was a method of preserving meat by marinating it in vinegar and salt. Over time, the dish evolved to include soy sauce, garlic, bay leaves, and black pepper. Adobo is typically made with either chicken or pork, or a combination of both, slowly simmered until the meat becomes tender and fully infused with the marinade. Variations exist across the archipelago: some regions use coconut milk (Adobo sa Gata), while others add pineapple for a touch of sweetness. Adobo’s versatility and robust flavor have made it a staple in Filipino households, often served with steamed white rice to balance its rich taste."
    },
    sinigang: {
        name: "Sinigang",
        info: "Category: Filipino | Price: ₱750 | Location: Cebu",
        description: "Sinigang is a quintessential Filipino dish celebrated for its bold and refreshing sourness, often regarded as one of the most comforting local soups. The name 'sinigang' originates from the Tagalog word 'sigang,' which means 'to stew.' The hallmark of this dish is its tamarind-based broth, although other souring agents like calamansi, green mango, or even guava can be used. Commonly prepared with pork, beef, shrimp, or fish, sinigang is packed with a variety of vegetables such as tomatoes, radish, eggplant, okra, string beans, water spinach (kangkong), and green chili. Each region has its own twist: Pampanga’s version might include miso, while in Visayas, batuan fruit is preferred as a souring agent. Sinigang’s harmonious balance of savory and sour flavors makes it an ideal comfort food, especially during the rainy season. Often served with a side of rice, its vibrant taste is both hearty and revitalizing, capturing the essence of Filipino culinary tradition."
    },
    lechon: {
        name: "Lechon",
        info: "Category: Filipino | Price: ₱900 | Location: Cebu",
        description: "Lechon is an iconic Filipino dish often regarded as the ultimate centerpiece at grand celebrations like fiestas, weddings, and holidays. The word 'lechon' is derived from the Spanish term for roasted suckling pig, but in the Philippines, it generally refers to a whole roasted pig, regardless of age. Introduced during the Spanish colonial period, lechon has since become synonymous with Filipino festivity. The preparation of lechon is a meticulous process: the pig is stuffed with aromatics like lemongrass, garlic, and onions, then slowly roasted over an open flame or charcoal pit for several hours. This roasting technique results in crispy, golden-brown skin while keeping the meat succulent and flavorful. In Cebu, the lechon is known for its distinct seasoning and slightly spicy flavor, while in Luzon, it is commonly served with a thick, savory liver sauce. The dish embodies communal spirit and tradition, symbolizing abundance and gratitude. Leftover lechon is often recycled into dishes like lechon paksiw, where it is stewed in vinegar and liver sauce."
    },
    sisig: {
        name: "Sisig",
        info: "Category: Filipino | Price: ₱450 | Location: Pampanga",
        description: "Sisig is a beloved Filipino dish hailing from Pampanga, known as the culinary capital of the Philippines. Its origins can be traced back to the creative resourcefulness of Kapampangan cooks who repurposed unused pig parts from American military bases. The word 'sisig' itself means 'to snack on something sour,' traditionally referring to a salad made from green papaya or other sour fruits. Today, sisig is made from finely chopped pig's face, ears, and often liver, which are boiled, grilled, and then sautéed with onions, chilies, and calamansi juice. It is typically served on a sizzling plate, topped with a raw egg that cooks from the residual heat, adding richness to the already flavorful dish. Modern variations include chicken, seafood, tofu, or even a crispy version, but the pork sisig remains the classic. Sisig's distinctive combination of crispy, fatty, and tangy elements makes it a popular pulutan (beer match) and comfort food, widely enjoyed in both humble eateries and upscale restaurants."
    },
    kareKare: {
        name: "Kare-Kare",
        info: "Category: Filipino | Price: ₱800 | Location: Quezon City",
        description: "Kare-Kare is a traditional Filipino stew known for its creamy, peanut-based sauce and hearty ingredients. The name likely comes from the word 'kari,' which means 'curry,' though Kare-Kare bears little resemblance to Indian curry. This dish traces its roots to the Kapampangan region, where it is believed to have originated as a festive meal, often prepared during special occasions. The rich, orange-hued sauce is made from ground roasted peanuts (or peanut butter), toasted rice, and annatto seeds for color. Kare-Kare is typically made with oxtail, beef shanks, tripe, and various vegetables such as eggplant, banana blossom, and string beans. The dish is traditionally served with bagoong (fermented shrimp paste), which balances the creamy and nutty flavors with a salty, umami kick. Over the years, modern variations have emerged, including seafood and vegetable versions, but the essence of Kare-Kare remains in its luscious sauce and comforting appeal. Its distinct taste and cultural significance make it a cherished part of Filipino cuisine, enjoyed with steamed rice and generous portions of bagoong."
    }
};

function showDish(dishKey) {
    const dish = dishes[dishKey];
    if (dish) {
        document.getElementById("dish-name").innerText = dish.name;
        document.getElementById("dish-info").innerText = dish.info;
        document.getElementById("dish-description").innerText = dish.description;
        document.getElementById("menu").style.display = "none";
        document.getElementById("dish").style.display = "block";
    }
}

function showMenu() {
    document.getElementById("menu").style.display = "flex";
    document.getElementById("dish").style.display = "none";
}
