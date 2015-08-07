var indexImage;
var $containerImage;
var indexFeature;
var $containerFeature;
var $containerPack;
var indexPack;
var $containerProductVariants;
var indexProductVariants;

$(document).ready(function() {
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    $containerImage = $('div#dywee_eshopbundle_product_images');
    $containerFeature = $('div#dywee_eshopbundle_product_features');
    $containerPack = $('div#dywee_eshopbundle_product_packElements');
    $containerProductVariants = $('div#dywee_eshopbundle_product_productVariants');

    // On ajoute un lien pour ajouter une nouvelle catégorie
    var $addImageLink = $('<a href="#" id="add_category" class="btn btn-default btn-block""><i class="fa fa-plus"></i> Ajouter une photo</a>');
    var $addFeatureLink = $('<a href="#" id="add_feature" class="btn btn-default btn-block""><i class="fa fa-plus"></i> Ajouter une caractéristique</a>');
    var $addPackLink = $('<a href="#" id="add_pack" class="btn btn-default""><i class="fa fa-plus"></i> Ajouter un produit</a>');
    var $addProductVariantLink = $('<a href="#" id="add_productVariant" class="btn btn-default""><i class="fa fa-plus"></i> Ajouter une variante du produit</a>');

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $addImageLink.click(function(e) {
        addImage($containerImage);
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    $addFeatureLink.click(function(e) {
        addFeature($containerFeature);
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    $addPackLink.click(function(e) {
        addPack($containerPack);
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    $addProductVariantLink.click(function(e) {
        addProductVariant($containerProductVariants);
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    indexImage = $containerImage.find(':input').length;
    indexFeature = $containerFeature.find(':input').length;
    indexPack = $containerPack.find(':input').length;
    indexProductVariants = $containerProductVariants.find(':input').length;

    // Pour chaque catégorie déjà existante, on ajoute un lien de suppression
    $containerImage.children('div').each(function() {
        addDeleteLink($(this));
    });
    $containerPack.children('div').each(function() {
        addDeleteLink($(this));
    });
    $containerProductVariants.children('div').each(function(){
        addDeleteLink($(this));
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    if (indexFeature == 0) {
        addFeature($containerFeature);
    } else {
        // Pour chaque catégorie déjà existante, on ajoute un lien de suppression
        $containerFeature.children('div').each(function() {
            addDeleteLink($(this));
        });
    }
    if (indexPack == 0) {
        //addPack($containerPack);
    } else {
        // Pour chaque catégorie déjà existante, on ajoute un lien de suppression
        $containerPack.children('div').each(function() {
            addDeleteLink($(this));
        });
    }


    $containerImage.append($addImageLink);
    $containerPack.append($addPackLink);
    $containerProductVariants.append($addProductVariantLink);

    function addPreviewImage($prototype)
    {
        console.log($($prototype).val());
    }

    // La fonction qui ajoute un formulaire Categorie
    function addImage(url) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var $prototype = $($containerImage.attr('data-prototype').replace(/__name__label__/g, 'Nouvelle photo')
            .replace(/__name__/g, indexImage));

        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $containerImage.append($prototype);

        $("#dywee_eshopbundle_product_images_"+indexImage+"_src").val(url);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        indexImage++;
    }

    function addFeature($container) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var $prototype = $($containerFeature.attr('data-prototype').replace(/__name__label__/g, '<p>Caractéristique n°</p>' + (indexFeature+1))
            .replace(/__name__/g, indexFeature));

        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $containerFeature.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        indexFeature++;
    }

    function addPack($container){
        var $prototype = $($containerPack.attr('data-prototype').replace(/__name__label__/g, '<p>Produit n°</p>' + (indexPack+1))
            .replace(/__name__/g, indexPack));
        addDeleteLink($prototype);
        $containerPack.append($prototype);
        indexPack++;
    }

    function addProductVariant($container)
    {
        var $prototype = $($containerProductVariants.attr('data-prototype').replace(/__name__label__/g, '<p>Produit n°</p>' + (indexProductVariants+1))
            .replace(/__name__/g, indexProductVariants));
        addDeleteLink($prototype);

        console.log('dywee_eshopbundle_product_productVariants_0_price');
        console.log('dywee_eshopbundle_product_productVariants_'+indexProductVariants+'_price');

        $prototype.find("[id$=dywee_eshopbundle_product_productVariants_"+indexProductVariants+"_price]").val($("#dywee_eshopbundle_product_price").val());
        $prototype.find("[id$=dywee_eshopbundle_product_productVariants_"+indexProductVariants+"_stock]").val($("#dywee_eshopbundle_product_stock").val());
        $prototype.find("[id$=dywee_eshopbundle_product_productVariants_"+indexProductVariants+"_promotionPrice]").val($("#dywee_eshopbundle_product_promotionPrice").val());
        console.log($("#dywee_eshopbundle_product_isPriceTTC").attr('checked'));
        if($("#dywee_eshopbundle_product_isPriceTTC").attr('checked') == "checked")
            $prototype.find("[id$=dywee_eshopbundle_product_productVariants_"+indexProductVariants+"_isPriceTTC]").attr('checked', 'checked');
        if($("#dywee_eshopbundle_product_isPromotion").attr('checked') == "checked")
            $prototype.find("[id$=dywee_eshopbundle_product_productVariants_"+indexProductVariants+"_isPromotion]").attr('checked', 'checked');


        $containerProductVariants.append($prototype);
        indexProductVariants++;
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
        // Création du lien
        $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');

        // Ajout du lien
        $prototype.append($deleteLink);

        // Ajout du listener sur le clic du lien
        $deleteLink.click(function(e) {
            $prototype.remove();
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }
});