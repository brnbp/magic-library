function deletar_registro(multiverseid)
{
    var dadosajax = {
        'multiverseid' : multiverseid,
        'wishlistdelcard' : true
    };

    pageurl = '/magicPhalcon/cards/wishedCard';

     $.ajax({
        url: pageurl,
        data: dadosajax,
        type: 'POST',
        cache: false,

        error: function(){
            alert('Erro: Inserir Registo!!');
        },
        success: function(result) {
            // pega ultimo caractere da string e verifica "retorno"
            if (result.substr(result.length - 1) == '1') {
                $("#cards_view_grid").load('#');
                alert("O seu registo foi deletado com sucesso!");
            } else {
                alert("Ocorreu um erro ao deletado o seu registo!");
            }
 
        }
    });

}

function inserir_registro(multiverseid)
{
    var dadosajax = {
        'multiverseid' : multiverseid,
        'wishlistaddcard' : true
    };

    pageurl = 'wishedCard';

     $.ajax({
        url: pageurl,
        data: dadosajax,
        type: 'POST',
        cache: false,

        error: function(){
            alert('Erro: Inserir Registro!!');
        },

        success: function(result) {

            // pega ultimo caractere da string e verifica "retorno"
            if (result.substr(result.length - 1) == '1') {
                alert("O seu registo foi inserido com sucesso!");
            } else if (result.substr(result.length - 1) == '2') {
                alert("Já existe um registro inserido com esse valor!");
            } else {
                alert("Ocorreu um erro ao inserir o seu registo!");
            }
 
        }
    });
}