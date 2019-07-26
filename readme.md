### WIP: Lite Brite (Local Setup)
This is a laravel app which controls two things: a photo booth camera and the panel of lights the results show up on. The purpose here is to have an interactive installation that saves data to a public, offsite location. This is the local setup of a two-part project. The other part can be found [here](https://github.com/bobbyleftovers/fen-qtt)

## What?
A user gets in front of the camera and presses a button to take the snapshot. The snapshot is saved and sent to the [main website](https://github.com/bobbyleftovers/fen-qtt), which also saves the file and then processes the data based on the image. When complete the main server sends a response with JSON data. That JSON contains data that the local app then uses to set up that image on the panel of lights. The lights are dimmable LED lights that have full color and 0-255 levels of dimmness, with 0 being off and 255 as full brightness.

## How?
There are a number of moving parts with this:
- A Rapberry Pi: Run the web server, take the snapshots, and send the data to the light panel according to the desired configuration
- Camera: A small camera sold for Rasperry Pi. Takes pretty nice photos.
- Light panels: Hand built grid of lights using [These LED strips](https://smile.amazon.com/jiachenled-flexible-Daylight-Non-waterproof-celebration/dp/B071JNJMS3?pf_rd_p=9dce798c-bef4-4763-ad3c-c17e34738b8b&pd_rd_wg=CqLyz&pf_rd_r=139W811F1DQS15DDKC7W&ref_=pd_gw_bia_d0&pd_rd_w=MC218&pd_rd_r=b9ba1433-45a4-41a4-9c15-e496fda95192). Each LED is individually addressable, so they act as pixels. These are wired into the GPIO pins on the Raspberry Pi and are triggered by Laravel calling a python script.
- Python: Laravel calls to a python script pass JSON data containing RGB and dimmness values for each pixel. It is a large data set. This part is currently incomplete.
