.. include:: ../Includes.txt

.. _annotations_hidden:

============
@Api\\IncludeHidden
============

Retrieve hidden records and relations from the database.
---------

This makes the TYPO3 Frontend behave like the Typo3 Backend: Hidden records and records with ``fe_group`` 
or ``starttime/endtime``-restrictions will be returned to the frontend, although they usually would only
be visible in the TYPO3 backend for admins.

**The syntax is:**

.. code-block:: php

   @Api\IncludeHidden("tablename")

.. tip::

   If you are using frontend-user authentication, you can also set the option to include hidden records
   on a per-user basis by setting the checkbox :ref:`"Admin-Mode" <configuration_feuser>` in the tab "RestApi" 
   of the frontend user entry.

Overview of options
---------

You can pass the tablename(s) or modelnames to ``@Api\IncludeHidden(...)``:

+--------------------------------------------------------+--------------------------------------------------------------+
| annotation                                             | description                                                  |
+========================================================+==============================================================+
| `@Api\IncludeHidden()`                                 | all entries with `hidden = 1` will be retrieved              |
+--------------------------------------------------------+--------------------------------------------------------------+
| `@Api\IncludeHidden("*")`                              | same as `*`                                                  |
+--------------------------------------------------------+--------------------------------------------------------------+
| `@Api\IncludeHidden("my_table")`                       | only entries from table `my_table` will be affected          |
+--------------------------------------------------------+--------------------------------------------------------------+
| `@Api\IncludeHidden("Nng\Apitest\Domain\Model\Entry")` | you can also use the model name instead                      |
+--------------------------------------------------------+--------------------------------------------------------------+
| `@Api\IncludeHidden({"tt_content", "my_table"})`       | only entries from given tables will be affected              |
+--------------------------------------------------------+--------------------------------------------------------------+

Example
---------

**Here is a full example:**

.. code-block:: php

   <?php
   
   namespace My\Extension\Api;

   use Nng\Nnrestapi\Annotations as Api;
   use Nng\Nnrestapi\Api\AbstractApi;

   /**
    * @Api\Endpoint()
    */   
   class Example extends AbstractApi
   {
      /**
       * @Api\IncludeHidden
       * @Api\Access("public")
       *
       * @return array
       */
      public function getAllAction() 
      {
         return $this->someRepository->findAll();
      }

   }


If you would like to handle the access to hidden records yourself, you can use
the ``\nn\rest::Settings()->setIgnoreEnableFields()`` helper before retrieving
your data from the repository.
 
.. code-block:: php

   <?php

   namespace My\Extension\Api;
   
   use Nng\Nnrestapi\Annotations as Api;
   use Nng\Nnrestapi\Api\AbstractApi;

   /**
    * @Api\Endpoint()
    */
   class Example extends AbstractApi
   {
      /**
       * @Api\Access("public")
       *
       * @return array
       */
      public function getAllAction() 
      {
         if ($this->yourOwnCheckMethod()) {
            // ignore hidden restrictions for ALL tables
            \nn\rest::Settings()->setIgnoreEnableFields( true );
            // ignore hidden restrictions for certain tables
            // \nn\rest::Settings()->setIgnoreEnableFields(['tt_content', 'my_table_name']);
         }
         return $this->someRepository->findAll();
      }

   }
