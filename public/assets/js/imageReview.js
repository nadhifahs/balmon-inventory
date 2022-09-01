var imagesPreview = function(input, placeToInsertImagePreview) {

    if (input.files) {
        var filesAmount = input.files.length;

        for (var i = 0; i < filesAmount; i++) {
            var reader = new FileReader();

            reader.onload = function(event) {
                var card = $('<div/>').attr({
                    class: 'col mx-1 card'
                })

                var divImage = $('<div/>').attr({
                    class: 'my-auto'
                })

                $($.parseHTML('<img>')).attr('src', event.target.result).attr('class', 'img-thumbnail imagePreview').appendTo(divImage);

                divImage.appendTo(card);

                var divFooter = $('<div/>').attr({
                    class: 'card-footer'
                })

                // buttonImage.appendTo(divFooter);
                divFooter.appendTo(card);
                card.appendTo(placeToInsertImagePreview);

                if($('.imagePreview').length > 10){
                    alert('Upload Gambar dibatasi hingga 10 gambar')
                    return;
                }
            }

            reader.readAsDataURL(input.files[i]);
        }
        }
    };
    //Menampilkan Thumbnail sebelum upload
    $('#gallery-photo-add').on('change', function() {
    imagesPreview(this, 'div.gallery');
    });

    //Menghapus Thumbnail apabila terdapat pergantian file upload
    $('#gallery-photo-add').on('click', function(){
    // console.log('Masuk')
    let parent = document.getElementById("isi-gallery")
    while (parent.firstChild) {
        parent.firstChild.remove()
    }
    });

