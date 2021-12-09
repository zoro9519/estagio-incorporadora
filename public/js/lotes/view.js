let headers = {
    "Content-Type": "application/json",
    "X-CSRF-TOKEN": tokenCRSF
}

var Venda = {
    corretores : [],
    searchUser: function() {

        $("#errorResultSearch").addClass("d-none");
        let document = $("#cpf_busca").val();
        let endpoint = "/users/search";
        let data = {
            document: document
        }
        
    
        HTTPClient.post(siteUrl + endpoint, JSON.stringify(data), headers).then((json) => {
            console.log(json);
            if (json.success) {
                let user = json.user;
                // resultSearch === dados do user
                // json.user
                console.table(user);
                $("#user_id").val(user.id);
                $("#cliente_nome").html(user.nome);
            } else {
                $("#errorResultSearch").html(json.error_message);
                $("#user_id").val("");
                $("#cliente_nome").html("");
                $("#errorResultSearch").removeClass("d-none");
    
            }
        });
    
    },

    queryCorretorByImobiliaria: function() {
        let imobiliariaId = $("#imobiliaria_filter").val();
        let endpoint = "/corretores";

        if(imobiliariaId){
            endpoint += "/" + imobiliariaId;
        }
        $("#corretores_available").attr("disabled", true);
        HTTPClient.get(siteUrl + endpoint, headers).then((json) => {
            console.log(json);
            if (json.success) {

                let corretores = "#corretores_available";
                $(corretores).empty().append("<option>Selecione</option>");

                json.corretores.forEach((item) => {

                    let newOption = $("<option >");
                    $(newOption).val(item.id);

                    let contentHTML = item.nome + (item.creci ? item.creci : "");
                    $(newOption).html(contentHTML);
                    
                    $(corretores).append(newOption);
                })

            } else {
                $("#errorResultSearch").html(json.error_message);
    
                $("#errorResultSearch").removeClass("d-none");
    
            }
        })
        .finally(() => {
            $("#corretores_available").attr("disabled", false);
        });
    

    }


}

var Reserva = {
    corretores : [],
    searchUser: function() {

        $("#errorResultSearch").addClass("d-none");
        let document = $("#cpf_busca").val();
        let endpoint = "/users/search";
        let data = {
            document: document
        }
        
    
        HTTPClient.post(siteUrl + endpoint, JSON.stringify(data), headers).then((json) => {
            console.log(json);
            if (json.success) {
                let user = json.user;
                // resultSearch === dados do user
                // json.user
                console.table(user);
                $("#user_id").val(user.id);
                $("#cliente_nome").html(user.nome);
            } else {
                $("#errorResultSearch").html(json.error_message);
    
                $("#errorResultSearch").removeClass("d-none");
    
            }
        });
    
    },

    queryCorretorByImobiliaria: function() {
        let imobiliariaId = $("#imobiliaria_filter").val();
        let endpoint = "/corretores";

        if(imobiliariaId){
            endpoint += "/" + imobiliariaId;
        }
        $("#corretores_available").attr("disabled", true);
        HTTPClient.get(siteUrl + endpoint, headers).then((json) => {
            console.log(json);
            if (json.success) {

                let corretores = "#corretores_available";
                $(corretores).empty().append("<option>Selecione</option>");

                json.corretores.forEach((item) => {

                    let newOption = $("<option >");
                    $(newOption).val(item.id);

                    let contentHTML = item.nome + (item.creci ? item.creci : "");
                    $(newOption).html(contentHTML);
                    
                    $(corretores).append(newOption);
                })

            } else {
                $("#errorResultSearch").html(json.error_message);
    
                $("#errorResultSearch").removeClass("d-none");
    
            }
        })
        .finally(() => {
            $("#corretores_available").attr("disabled", false);
        });
    

    }


}


$("#searchCliente").on("click", Venda.searchUser);
$("#imobiliaria_filter").on("change", Venda.queryCorretorByImobiliaria);