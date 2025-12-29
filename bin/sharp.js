const sharp = require('sharp');

(async () => {
    const arguments = process.argv.slice(2);
    const svgFilePath = arguments[0];
    const format = arguments[1];
    const operations = arguments[2] ? JSON.parse(arguments[2]) : null;

    // Initialize sharp with input file
    let image = sharp(svgFilePath);

    // Apply format conversion
    image = image.toFormat(format);

    // Apply image operations if provided
    if (operations) {
        for (const [operation, params] of Object.entries(operations)) {
            switch (operation) {
                case 'resize':
                    image = image.resize(params.width, params.height, params.options);
                    break;
                case 'rotate':
                    image = image.rotate(params.angle, params.options);
                    break;
                case 'flip':
                    image = image.flip();
                    break;
                case 'flop':
                    image = image.flop();
                    break;
                case 'blur':
                    image = image.blur(params.sigma);
                    break;
                case 'sharpen':
                    image = image.sharpen(params.sigma, params.flat, params.jagged);
                    break;
                case 'grayscale':
                    image = image.grayscale();
                    break;
                // Add more operations as needed
            }
        }
    }

    const result = await image.toBuffer();
    process.stdout.write(result);
})();
