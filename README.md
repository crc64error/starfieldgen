# StarGen PHP

## Overview
StarGen PHP is an open-source project designed to generate dynamic, visually appealing starfields and nebulae images using SVG format. Inspired by the beauty of the deep field images from Hubble and JWST, this project uses PHP to create complex starfields that include randomly placed stars, galaxies, and nebula-like formations, mimicking the deep field images captured by telescopes like Hubble.

## Features
- **Dynamic Starfields**: Generates unique starfields every time the script is run.
- **Customizable Parameters**: Users can adjust the density of stars and galaxies, as well as the color schemes used for different celestial objects.
- **SVG Output**: The output is in SVG format, making it scalable and suitable for various applications including web backgrounds, scientific illustrations, and more.

## Layers
- Layer 1 is the nebulosity in the image. I keep this pretty subtle. But the parameters on lines 92-95 of stargen.php affect this generation
- Layer 2 is an semi opaque dark layer to further mute the brightness of the nebulosity in one place.
- Layer 3 is the normal white stars.  The number of these stars is adjusted at Line 6 $numStars = rand(2500, 6000); 2500 being minimum and 6000 being max.
  - I will be adding a subtle color shift in a randomn region towards red shift or blue shift, in the future.
- Layer 4 is the galaxies, this is the part I am struggling with. Galaxies are not round, but flattend curved discs and other odd shapes.  This is a work in progress.
  - Using clipped images randomnly placed, colored and rotated is an option, but it would be more expensive
  - Using filters to alter spheres is an option, maybe?
  - Using random paths to draw shapes is an option, probably the best?

## Getting Started

### Prerequisites
- PHP 7.4 or higher
- A web server like Apache or Nginx capable of serving PHP files

### Installation
1. Clone this repository to your local machine or web server document root:
   ```bash
   git clone https://github.com/yourusername/stargen.php.git

2. Navigate to your project directory:
   ```bash
   cd starfieldgen

3. Adjust the various values in the script to try other variations.

4. Load localhost/starfieldgen/stargen.php to try it directly.

Or

5. Add the starfield.css to the document where you wish to use the generated image as the background of. 

6. Make sure no other css is interfering.

7. Adjust parameters thru out stargen.php to make changes, and refresh the preview page.
