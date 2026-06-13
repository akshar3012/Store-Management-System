<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us Form</title>
                                
    <style>
	*{
    margin: 0%;
    padding: 0%;
    box-sizing: border-box;
    font-size: 'open sans' 'sans-farens';

}
body{
    height: 100vh;
    background-color: #000;
    background-size: cover;
    background-position: center; 
}

li{
    list-style: none;
}

body{
    height: 100vh;
    background-color: #000;
    background-image: url('https://wallpapers.com/images/hd/tree-on-hill-under-evening-sky-tner4b7sig9fm5mc.jpg');
    background-size: cover;
    background-position: center;
}
li{
    list-style: none;
}
a{
    text-decoration: none;
    color:white;
    font-size: 1.7rem;
    border-top: 20px;
}
a:hover{
    color: orange;
}
header{
    position: relative;
    padding: 0 2.5rem;

}
.navbar{
    width: 100%;
    height: 60px;
    max-width: 1200px;
    margin: 0 auto;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    
}


.navbar .logo a {
     
    font-size: 2.7rem;
    margin-top: 20px;
    font-weight: Bold;
    

}

.navbar .links{
    display: flex;
    gap: 2.7rem;
    margin-top: 35px;
}
.navbar .toggal_btn{
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: none;
}
.action_btn{
    background-color: orange;
    color: white;
    border: none;
    outline: none;
    border-radius: 20px;
    padding: 0.5rem 1rem;
    margin-top: 30px;
    font-size: 1.3rem;
    font-weight: bold;
    margin: 50px;
    cursor: pointer;
    transition: scale  0.2 ease;

}
.action_btn:hover{
    color: white;
    scale: 1.05;
}
section#hero {
    height: calc(100vh - 60px);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
}


#hero h1{
    font-size: 4.7rem;
    margin-top: 300px;
    font-weight: bold;
    color: #fff;
    border-color: solid black;


}
.form{
    display: flex;
    flex-direction: column;
    height: 400px;
    width: 350px;
    border: 1px solid black;
    align-items: center;
    margin: auto;
    margin-top: 800px;
    margin-left: 150px;
    background-color:rgba(0, 0,  0, 0.5);
    border-color: white;
    box-shadow: 2px 2px 15px rgba( 255, 255, 255, 0.5);
    color: white;
    border-radius: 30px;
    
}

.form h1{
    color: aliceblue;
    font-size: 2rem;
    border-bottom: 4px solid whitesmoke;
    margin: 30px;
}

.box{
    padding: 10px;
    margin: 15px;
    border-radius: 25px;
    border: none;
    outline: none;
    background-color:rgba(220, 191, 191, 0.5);
    box-shadow: 2px 2px 15px rgba( 255, 255, 255, 0.5);
    color: white;
    margin-left: 170px;
    font-size: 1rem; 
}
 #submit{
    padding: 10px 20px;
    margin-top: 20px;
    width: 50%;
    background-color: rgba(220, 191, 191, 0.5);
    
    color: white;
    border-radius: 20px;
    font-size: 1rem;

}
#submit:hover{
    cursor: pointer;
    background-color: rgba(239, 112, 112, 0.5);
    color: black;
}
::placeholder{
    color: black;
    opacity: 0.7;
}
        *{
            margin: 0%;
            padding: 0%;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
	
        .container{
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #20223a;  /* url('https://wallpapers.com/images/hd/information-technology-1440-x-900-background-p1c1dbydenflfzeo.jpg'); */
            background-repeat: no-repeat;
            background-size: cover;
        }
        .container form{
            width: 680px;
            height: 450px;
            display: flex;
            justify-content: center;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            flex-wrap: wrap;
        }
        .container form h1{
            color: #fff;
            font-weight: 700;
            line-height: 2;
            margin-top: 20px;
            width: 500px;
            text-align: center;
        }
        .container form input{
            width: 300px;
            height: 50px;
            padding-left: 10px;
            outline: none;
            border: none;
            font-size: 20px;
            margin-bottom: 10px;
            background: none;
            border-bottom: 2px solid #fff;
            color: darkturquoise;
        }
        .container form input::placeholder{
            color: #fff;
        }
        
      
       
        .container form h4{
            color: #fff;
            font-weight: 300;
            font-family: Arial, Helvetica, sans-serif;
            width: 600px;
            margin-top: 20px;

        }
        .container form textarea{
            background: none;
            border: none;
            border-bottom: 2px solid white;
            color: #fff;
            font-weight: 200;
            font-size: 20px;
            padding: 10px;
            outline: none;
            min-height: 90px;
            max-height: 90px;
            min-width: 620px;
            max-width: 620px;
        }
        .container form #EntreLastName , 
        .container form #Mobile {
            margin-left: 20px;
        }
        .container form h4{
            font-size: 20px;
        }
        .container form #Button{
            border: none;
            background-color: white;
            border-radius: 10px;
            margin-top: 19px;
            font-weight: 600;
            font-size: 24px;
            color: black;
            width: 180px;
            height: 50px;
            padding: 0;
            margin-bottom: 20px;
            transform: .3s;
        }
        .container form #Button:hover{
            background-color: black;
            color: #fff;
            transition: .2s ease-in-out;
        }

        #id{
            margin-left: 30px !important;
        }

    </style>
</head>
<body>
     <div class="container">
        <form>
            <h1>Contact Us</h1>
            <input type="text" placeholder="Enter First Name" id="Enter First Name" required>
            <input type="text" placeholder="Enter Last Name" id="id" required>
            <input type="text" placeholder="Email" id="Email" required>
            <input type="text" placeholder="Mobile" id="Mobile" required>
            <h4> Type  Your Massage Here....</h4>
            <textarea required></textarea>
            <input type="Submit" value="Send" id="Button" required>
        </form>
                
        </form>
     </div>
    
</body>
</html>