# Mass Product Duplicate
Using this module we can create duplicate products based on some attribute

1. A attribute codename 'condition' should be assigned to product which has 3 labels with name new, old, refurbished
Note : it can also be written in setup script, but it may be alreadu there and can be created from adminmanually as well.

2. It seach for all products which has new attribute and create duplicate of it.

3. Coomand to run : php bin/magento kushal:copy

4. Batch processing would not be required as it is shell based command and will not be timed out for large catalog or can be run as background process.

5. Magento 2 default logging is used

6. Magento 2 default duplicator is used


Test Requirements : Create a Magento module (Command line utility/admin module) to copy all the existing simple products (New) in set of 2 (used and refurbished) also modify the attributes of copied products as below: 


    Main product: -   

        Name: LG LED New TV 

        SKU - LG_LED_TV_NEW 

        Condition(attribute): new 

        URL: lg-led-new-tv 

        Meta title: Lg led new tv at best price in city 

2 copies of above products should be created with attributes values modified as below 

    Copy 1 

    Name: LG LED used TV 

    SKU - LG_LED_TV_USED 

    Condition(attribute): used 

    URL: lg-led-used-tv 

    Meta title: Lg led used tv at best price in city 

 

    Copy 2 

    Name: LG LED refurbished TV 

    SKU - LG_LED_TV_REFURBISHED 

    Condition(attribute): refurbished 

    URL: lg-led-refurbished-tv 

    Meta title: Lg led refurbished tv at best price in city 

 

Please take into consideration following points while developing the feature: 

    Exception handling is must 

    Logging feature is good to have -- Add logs of all the activities happening while code execution 

    Make use of Inheritance, dependency injection, interface, abstract class and static methods 

    Organized code base using helper/libraries will be a plus point 

    Standard PHP code guidelines should be followed 

    Batch processing is expected when catalog is big in size 




