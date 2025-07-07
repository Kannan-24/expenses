import tinymce from 'tinymce/tinymce';

import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/image';
import 'tinymce/icons/default';
import 'tinymce/themes/silver';

import 'tinymce/skins/ui/oxide/skin.min.css';

tinymce.init({
    selector: 'textarea#editor',
    height: 300,
    menubar: false,
    branding: false,
    plugins: 'link lists image',
    toolbar: 'undo redo | blocks | bold italic | bullist numlist | link image',
    paste_as_text: true,
    block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3',

    base_url: '/tinymce',
    license_key: 'gpl',
    promotion: false,

    paste_data_images: true,
    images_upload_url: '/upload-image',
    automatic_uploads: true,
    images_upload_handler: function (blobInfo, success, failure) {
        let formData = new FormData();
        formData.append('image', blobInfo.blob());

        fetch('/upload-image', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
            .then(res => res.json())
            .then(data => success(data.location))
            .catch(() => failure('Upload failed'));
    },
    content_css: "dark",
    skin: "oxide-dark",



});
