var indexPicture;
var $containerPicture;

$(document).ready(function() {
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    $containerPicture = $('div#product_pictures');

    // On ajoute un lien pour ajouter une nouvelle catégorie
    var $addPictureLink = $('<a href="#" id="add_picture" class="btn btn-default btn-block""><i class="fa fa-plus"></i> Ajouter une photo</a>');

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $addPictureLink.click(function(e) {
        addPicture($containerPicture);
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    indexPicture = $containerPicture.find(':input').length;


    // Pour chaque catégorie déjà existante, on ajoute un lien de suppression
    $containerPicture.children('div').each(function() {
        addDeleteLink($(this));
    });

    $('input[id^="product_pictures_"]').fileinput({showUpload: false, showRemove: false});

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    $containerPicture.append($addPictureLink);


    // La fonction qui ajoute un formulaire Categorie
    function addPicture(url) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var $prototype = $($containerPicture.attr('data-prototype').replace(/__name__label__/g, '')
            .replace(/__name__/g, indexPicture));

        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $containerPicture.append($prototype);
        $('input[id^="product_pictures_"]').fileinput({showUpload: false, showRemove: false});

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        indexPicture++;
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