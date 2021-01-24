# Mass Product Duplicate
Using this module we can create duplicate products based on some attribute

1. A attribute codename 'condition' should be assigned to product which has 3 labels with name new, old, refurbished
Note : it can also be written in setup script, but it may be alreadu there and can be created from adminmanually as well.

2. It seach for all products which has new attribute and create duplicate of it.

3. Coomand to run : php bin/magento kushal:copy

4. Batch processing would not be required as it is shell based command and will not be timed out for large catalog or can be run as background process.

5. Magento 2 default logging is used

6. Magento 2 default duplicator is used


