# masoom-sph-test

This custom module "jugaad_products" has created for sph-test.

Here I have created a custom module to create a content type "Jugaad products", and a QR code block to display with "Jugaad products" node detail page.

I used yml files for content type and their fields in "/config/install/" folder, so that when this module get enabled/install then "Jugaad products" content type and fields will be created.

I have created a config form "jugaad_products_admin_settings" for admin to save the default size and margin of QR code image.

I have created a block "jugaad_product_qr_code_block" to display the QR code image in "Jugaad products" node detail page with the product.

I used the "endroid/qr-code-bundle" library to generate the QR code, I coded the program in "/Response/QRImageResponse" class. Here I used the "Builder::create()" function to generate the QR code and displayed in custom block.

I used the controller to call the "QRImageResponse" function and provide required attributes.

Error:

During development, I faced the issue related to content type creation by yml file, so I Google and solution and apply to resolve the issue.
I also faced an error for "ErrorCorrectionLevel" class in endroid/qr-code-bundle" library, So I used the latest library version and used the code from the readme file to generate the QR code.
