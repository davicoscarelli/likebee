# Like Bee

### Caring Together, Because Everyone Counts – Using AI and IoT to increase recycling rates and unite people upon this cause.

Advanced yet simple. Like Bee basic functionalities work based on our intelligent waste bins, the HiveBins, which are installed at public spaces, shopping centers, restaurants and etc. Those trash bins are constantly locked and in order to use them, one must first connect with it through a QR code. After connecting, the HiveBin will keep its door unlocked for 12 seconds. The waste must be disposed one item per time, and each time something is added, one picture of the inside of the HiveBin is taken. After the 12 seconds, all the pictures are analyzed by a convolutional neural network (run into the device) which identifies what kind of waste was disposed on it, and the resulting amount of Like Bee points is sent to the user account according to what was disposed (e.g.: 15 points for a 2L pet bottle, 10 points for a 1L one, and 1 point for a straw). Besides that, if any non-recyclable waste is deposed (e.g.: organic garbage) the user connected with the HiveBin receives one strike. 
In the end of each day all HiveBins around a city send statics regarding what was disposed on each device (e.g.: the number of each different type of recyclable waste) to a specific database. These data may be used by the local government to focus its awareness campaigns regarding the environment in the neediest areas. All this data transition is done thought our IoT system, which we plan on basing in LoRaWAN technology—but we may use mobile data in sim chips at first, while there are just a few HiveBins in use.

<p align="center">
  <a href="https://github.com/davicoscarelli/likebee/wiki"><img src="https://user-images.githubusercontent.com/48040161/89069489-9ee36f00-d349-11ea-85bd-bb1e009b442c.png"></a>
</p>
