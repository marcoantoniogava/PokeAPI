document.getElementById("search-form").addEventListener("submit", function(event) { //submit pq a funcao padrao de um form é o submit
    event.preventDefault(); //pagina para de recarregar ao enviar o form
    
    const form = event.target; //formulario vai ser o event q foi pego na linha 1
    const pokemonName = form.elements["pokemon_name"].value; //pega o valor do input (caixa de texto onde digita o nome do pokemon)
    console.log(pokemonName);

    //Colocando os elementos do html em variaveis para que possamos alterar
    const pokemonImage = document.getElementById("pokemon-image"); //atribui a variavel pokemonImage a imagem do pokemon
    const pokemonNameElement = document.getElementById("pokemon-name"); //atribui a variavel pokemonNameElement o nome do pokemon
    const pokemonID = document.getElementById("pokemon-id"); //atribui a variavel pokemonID o ID do pokemon
    const pokemonType = document.getElementById("pokemon-type"); //atribui a variavel pokemonType o tipo do pokemon
    const pokemonDescription = document.getElementById("pokemon-description"); //atribui a variavel pokemonDescription a descrição do pokemon

    //Mudar texo e imagem ao apertar o botao de busca
    pokemonNameElement.textContent = "Buscando...";
    pokemonID.textContent = "";
    pokemonType.textContent = "";
    pokemonDescription.textContent = "";
    pokemonImage.src = "https://www.dokhospitalveterinario.com.br/wp-content/uploads/2023/02/Quais-sao-os-tipos-de-calopsitas.jpg";

    //Conexão com o php
    fetch(`buscar.php?pokemon_name=${pokemonName}`)
                .then(response => response.json())
                .then(data => {
                    pokemonImage.src = data.image;
                    pokemonNameElement.textContent = data.name;
                    pokemonID.textContent = data.id;
                    pokemonType.textContent = data.type;
                    pokemonDescription.textContent = data.description;
                    //se a requisição der certo vai cair aq
                })
                .catch(error => {
                    console.log(error);
                    //se a requisição der errado vai cair aq
                })

})

