```mermaid
---
title: Class Inheritance Diagram - Webshop
---
classDiagram
    note "+ = public, - = private, # = protected"
    %% A <|-- B means that class B inherits from class A %%

    HtmlDoc <|-- BasicDoc

    BasicDoc <|-- HomeDoc
    BasicDoc <|-- AboutDoc
    BasicDoc <|-- FormDoc
    BasicDoc <|-- ProductDoc

    FormDoc <|-- ContactDoc
    FormDoc <|-- LoginDoc
    FormDoc <|-- RegisterDoc
    FormDoc <|-- TablesDoc

    ProductDoc <|-- CartDoc
    ProductDoc <|-- OrdersDoc
    ProductDoc <|-- ProductDetailsDoc
    ProductDoc <|-- WebshopDoc
    
    class HtmlDoc{
       +show()
       -showHtmlStart()
       -showHeaderStart()
       #showHeaderContent()
       -showHeaderEnd()
       -showBodyStart()
       #showBodyContent()
       -showBodyEnd()
       -showHtmlEnd()
    }
    class BasicDoc{
        #data 
        +__construct(mydata)
        #showHeaderContent()
        -showTitle()
        -showCssLinks()
        #showBodyContent()
        #showHeader()
        -showMenu()
        #showContent()
        -showFooter()
    }
    class HomeDoc{
        #showHeader()
        #showContent()
    }
    class AboutDoc{
        #showHeader()
        #showContent()
    }
    class FormDoc{
        <<abstract>>
        #showFormStart()
        #showFormEnd()
        #showFormField()
        #showErrorSpan()
        #showBuyAction()
        #showAddToCartAction()
    }
    class ProductDoc{
        <<abstract>>
        #getWebshopProductDetails()
        #getWebshopProducts()
        #getCartLines()
        #getRowsByOrderId()
        #getOrdersAndSum()
        #writeOrder
    }
    class ContactDoc{
        #showHeader()
        #showContent()
        #showFormStart()
        #showFormEnd()
        #showFormField()
        #showErrorSpan()
        #showBuyAction()
        #showAddToCartAction()
    }
    class LoginDoc{
        #showHeader()
        #showContent()
        #showFormStart()
        #showFormEnd()
        #showFormField()
        #showErrorSpan()
        #showBuyAction()
        #showAddToCartAction()
    }
    class RegisterDoc{
        #showHeader()
        #showContent()
        #showFormStart()
        #showFormEnd()
        #showFormField()
        #showErrorSpan()
        #showBuyAction()
        #showAddToCartAction()
    }
    class CartDoc(){
        #showHeader()
        #showContent()
    }
    class OrdersDoc(){
        #showHeader()
        #showContent()
    }
    class ProductDetailsDoc(){
        #showHeader()
        #showContent()
    }
    class TablesDoc(){
        #showHeader()
        #showContent()
    }
    class WebshopDoc(){
        #showHeader()
        #showContent()
    }

```
