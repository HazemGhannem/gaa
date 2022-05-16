/*
 * Copyright (c) 2016, Codename One
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated 
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation 
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, 
 * and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions 
 * of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A 
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF 
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE 
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 */

package com.codename1.uikit.pheonixui;

import com.codename1.components.FloatingHint;
import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.Display;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.plaf.UIManager;
import com.codename1.ui.spinner.Picker;
import com.codename1.ui.util.Resources;
import com.codename1.uikit.entities.Task;
import com.codename1.uikit.services.Service;



/**
 * Signup UI
 *
 * @author Shai Almog
 */
public class SignUpForm extends BaseForm {
    Service su =  new Service();
    Resources theme;
    public SignUpForm(Resources res) {
        super(new BorderLayout());
      
        Toolbar tb = new Toolbar(true);
        setToolbar(tb);
        tb.setUIID("Container");
        getTitleArea().setUIID("Container");
        Form previous = Display.getInstance().getCurrent();
        tb.setBackCommand("", e -> previous.showBack());
        setUIID("SignIn");
       
        TextField firstname = new TextField("", "firstname", 20, TextField.ANY);
        TextField lastname = new TextField("", "lastname", 20, TextField.EMAILADDR);
        TextField password = new TextField("", "password", 20, TextField.PASSWORD);
       
        TextField age = new TextField("", "age", 20, TextField.ANY);
        TextField email = new TextField("", "email", 20, TextField.ANY);
        TextField sexe = new TextField("", "sexe", 20, TextField.ANY);
        
        
        
       firstname.setSingleLineTextArea(false);
        lastname.setSingleLineTextArea(false);
        email.setSingleLineTextArea(false);
        password.setSingleLineTextArea(false);
       age.setSingleLineTextArea(false);
        sexe.setSingleLineTextArea(false);
        
        
       
        Button next = new Button("Next");
        Button signIn = new Button("Sign In");
        signIn.addActionListener(e -> previous.showBack());
        signIn.setUIID("Link");
        Label alreadHaveAnAccount = new Label("Already have an account?");
        
        Container content = BoxLayout.encloseY(
                new Label("Sign Up", "LogoLabel"),
                
                 new FloatingHint(firstname),
                createLineSeparator(),
                new FloatingHint(email),
                createLineSeparator(),
                new FloatingHint(lastname),
                createLineSeparator(),
                new FloatingHint(age),
                createLineSeparator(),
                new FloatingHint(sexe),
               
                createLineSeparator(),
                new FloatingHint(password),
                createLineSeparator() );
        content.setScrollableY(true);
        add(BorderLayout.CENTER, content);
        add(BorderLayout.SOUTH, BoxLayout.encloseY(
                next,
                FlowLayout.encloseCenter(alreadHaveAnAccount, signIn)
        ));
        next.requestFocus();
        next.addActionListener((ActionEvent e) -> {
            Task u =new Task(Integer.valueOf(age.getText()) ,  firstname.getText(),  lastname.getText(), sexe.getText() ,  password.getText() ,email.getText() );
       su.addTask(u);
       theme=UIManager.initFirstTheme("/theme5");
       new SignInForm(theme).show();
               
               });
    }
    
}
