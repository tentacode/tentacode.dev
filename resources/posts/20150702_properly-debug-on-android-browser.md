# Properly debug on Android browser

Oh hi! Long time no see! A lot of stuff happened: with the launch of my new project https://diwi.com we've been really busy (a detailled blog post on this to come later), and I also was writing a super long blog post about Behat but lost motivation along the way…

Anyway, as I said Diwi was a big project, launched really recently and we still have a lot to do. One of our biggest concern is to be sure that the mobile version of Diwi is working properly on every possible devices, and recently we had several users reporting an issue with picture upload and the default Android browser running on Android 4.3 Jellybean. 

Sooooo how would we test that? We own some Android devices (but there is mostly apple fanboys here), our devices are on more recent versions and the Android browser is really specific, it would be great to have a way to test any kind of devices / OS version on your computer right? Well, it's possible with the Android's SDK device emulator. There's some resources on the web already but as I did not find something really synthetic and I needed to explain the setup to my brotegrator [@IAmNotCyril](https://twitter.com/iamnotcyril) anyway, might as well make a post about it.

## Software setup

We will be using the Android SDK, my setup will be on mac but the setup should be similar on Windows. First grab and install [Android Studio on the offical website](https://developer.android.com/sdk/index.html). You might also need to install Java JDK 6 or 7 (if testing Android 5.0 >).

Launch and setup Android studio (with Standard configuration), it will then download various stuff.

## Create the mobile device

Open Android studio and create a new project:
![Android create new project](/img/posts/android_emulation_1.png)
As we are not **really** developing an Android application and just want to run the emulator, you can keep the default configuration in the new project wizzard, just pick the correct SDK version you need.

When the project windows pops up after the setup, wait for the indexing to finish (check the progress bar at the bottom right). When it's done click on the "Run app" button, and wait a bit more:
![Run app](/img/posts/android_emulation_2.png)
Here is the important part, we will create our own little device, note that you can also use an existing Android phone you own:
![Choose device](/img/posts/android_emulation_3.png)
![Device list](/img/posts/android_emulation_4.png)
Click on "Create Virtual Device…", then select the device you want or create your own:
![Select device](/img/posts/android_emulation_5.png)
In the list of operating system, find the exact version you need to test and click on the download link:
![Download OS version](/img/posts/android_emulation_6.png)
Choose the version in the list and **VOILÀ**, your device is ready!
![Choose system](/img/posts/android_emulation_7.png)
![Device dettings](/img/posts/android_emulation_8.png)
You can tweak settings a bit, but defaults are set for maximum perfomance.

If at this point you have an error that shows "Failed to load" in your virtual devices, you probably need to install the corresponding SDK in "Tools / Android / SDK Manager"
![Failed to load](/img/posts/android_emulation_9.png)
![SDK manager](/img/posts/android_emulation_10.png)
You should be able to launch the emulator now, a little more patience and you should have a working Android device:
![Launch emulator](/img/posts/android_emulation_11.png)
![Diwi homepage](/img/posts/android_emulation_12.png)

## Debug your device

Now that you've reproduced the issue and can safely blame your colleague for the bug, how do you debug it? The first thing to note is that you can use the `10.0.2.2` IP to access your local computer, you should configure your webserver to fallback to your project if no site name is given, or use ports to forward to it.
![Access to your local server](/img/posts/android_emulation_13.png)
Next helpful thing is typing "about:debug" in the URL, this should not output anything but it will pop a "Javascript Console" link, **but only if there is a javascript error on the current page**:
![Activate debug](/img/posts/android_emulation_14.png)
![Show javascript console](/img/posts/android_emulation_15.png)

## More stuff

I'm pretty sure there is a lot more stuff you can do with the Android emulator, you can probably install other browser to debug, and you can also use your own Android device to debug. I have not tried anything else yet but if you have other tips, please do leave a comment bellow.

I'm also aware that other emulators exist, like [Genymotion](https://www.genymotion.com/#!/) for example, but I did not have the time to try one yet.

