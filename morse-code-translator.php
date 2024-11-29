<?php
/*
Plugin Name: Morse Code Translator
Version: 1.0
Author: umamaheswararao s
*/

// Register the shortcode [morse_code_translator]
add_shortcode('morse_code_translator', 'morse_code_translator_shortcode');

// Function to generate the Morse Code Translator interface
function morse_code_translator_shortcode() {
    ob_start();
    ?>
    <div style="text-align: center; margin-top: 50px;">
        <h1>Morse Code Translator</h1>

        <!-- Morse to Text Section -->
        <h2>Morse to Text</h2>
        <textarea id="morseInput" rows="3" placeholder="Enter Morse Code (use spaces between letters and '/' for spaces between words)" style="width: 80%; padding: 10px; font-size: 16px; margin: 10px;"></textarea><br>
        <button id="translateMorseButton" style="padding: 10px 20px; font-size: 16px;">Translate to Text</button>
        <p id="textOutput" style="font-size: 20px; font-weight: bold;"></p>

        <!-- Text to Morse Section -->
        <h2>Text to Morse</h2>
        <input type="text" id="textInput" placeholder="Enter text here" style="width: 80%; padding: 10px; font-size: 16px; margin: 10px;">
        <button id="translateTextButton" style="padding: 10px 20px; font-size: 16px;">Translate to Morse Code</button>
        <p id="morseOutput" style="font-size: 20px; font-weight: bold;"></p>
    </div>

    <?php
    // Enqueue script for handling translation logic
    add_action('wp_footer', 'morse_code_translator_script');
    
    return ob_get_clean();
}

// Function to enqueue the JavaScript code for Morse Code translation
function morse_code_translator_script() {
    ?>
    <script>
        // Morse code dictionary for letters and numbers
        const morseCode = {
            'A': '.-',    'B': '-...',  'C': '-.-.',  'D': '-..',   'E': '.',
            'F': '..-.',  'G': '--.',   'H': '....',  'I': '..',    'J': '.---',
            'K': '-.-',   'L': '.-..',  'M': '--',    'N': '-.',    'O': '---',
            'P': '.--.',  'Q': '--.-',  'R': '.-.',   'S': '...',   'T': '-',
            'U': '..-',   'V': '...-',  'W': '.--',   'X': '-..-',  'Y': '-.--',
            'Z': '--..',  '1': '.----', '2': '..---', '3': '...--', '4': '....-',
            '5': '.....', '6': '-....', '7': '--...', '8': '---..', '9': '----.',
            '0': '-----', ' ': '/'    
        };

        // Reverse dictionary for Morse to Text
        const textCode = Object.entries(morseCode).reduce((acc, [key, value]) => {
            acc[value] = key;
            return acc;
        }, {});

        // Function to translate Morse to Text
        function translateMorseToText() {
            const morseInput = document.getElementById("morseInput").value.trim();
            const morseWords = morseInput.split(" / "); // Using '/' as a separator between words
            const translatedText = morseWords.map(word => 
                word.split(" ").map(symbol => textCode[symbol] || "").join("")
            ).join(" ");
            document.getElementById("textOutput").textContent = translatedText || "Invalid Morse Code!";
        }

        // Function to translate Text to Morse
        function translateTextToMorse() {
            const textInput = document.getElementById("textInput").value.toUpperCase().trim();
            const translatedMorse = textInput.split("").map(char => morseCode[char] || "").join(" ");
            document.getElementById("morseOutput").textContent = translatedMorse || "Invalid Text!";
        }

        // Attach event listeners to buttons
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("translateMorseButton").addEventListener("click", translateMorseToText);
            document.getElementById("translateTextButton").addEventListener("click", translateTextToMorse);
        });
    </script>
    </script>
    <?php
}
?>
