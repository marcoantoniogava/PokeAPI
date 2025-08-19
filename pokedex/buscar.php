<?php
header("Content-Type: application/json"); //Definir resposta como JSON
header("Access-control-Allow-Origin: *");
header("Access-control-Allow-Methods: GET, POST, OPTIONS");
header("Access-control-Allow-Headers: Content-Type, Authorization");

//Definição da response padrão
$response = array(
    "success" => false,
    "name" => "Pokémon não encontrado",
    "id" => "",
    "type" => "",
    "description" => "Tente outro nome",
    "image" => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/0.png"
);

if (!empty($_GET["pokemon_name"])) {
    $searchName = strtolower(trim($_GET["pokemon_name"]));

    $url = "https://pokeapi.co/api/v2/pokemon/" . $searchName; // . é pra concatenar

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $apiResponse = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode == 200) {
        $pokemonData = json_decode($apiResponse, true);

        $pokemonName = ucfirst($pokemonData['name']); //ucfirst deixa a primeira letra em maiusculo
        $pokemonId = $pokemonData['id'];
        $pokemonType = ucfirst($pokemonData['types'][0]['type']['name']);
        $pokemonImage = $pokemonData['sprites']['other']['official-artwork']['front_default'];

        $descUrl = $pokemonData['species']['url'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $descUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $descResponse = curl_exec($ch);
        curl_close($ch);

        $descData = json_decode($descResponse, true);

        $description = "";
        foreach($descData['flavor_text_entries'] as $entry) {
            if ($entry['language']['name'] == 'en') {
                $description = $entry['flavor_text'];
                break;
            }
        }

        $response = array(
            "success" => true,
            "name" => $pokemonName,
            "id" => $pokemonId,
            "type" => $pokemonType,
            "description" => $description,
            "image" => $pokemonImage
        );

    }
}

echo json_encode($response); //codifica a resposta como JSON
?>
