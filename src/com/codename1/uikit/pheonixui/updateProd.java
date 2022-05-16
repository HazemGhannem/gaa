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

import com.codename1.capture.Capture;
import com.codename1.components.ImageViewer;
import com.codename1.ui.Button;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.FontImage;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.spinner.Picker;
import com.codename1.ui.util.Resources;
import com.codename1.uikit.entities.Task;
import  com.codename1.uikit.services.Service;
import java.io.IOException;

/**
 * The newsfeed form
 *
 * @author Shai Almog
 */
public class updateProd extends BaseForm {
EncodedImage enim;
 Image img;
 ImageViewer imv;
 String pp="";


 Resources r;


    public updateProd(Resources res,Task t) {
        
      super("Blog", BoxLayout.y());
      installSidemenu(res);
      getToolbar().addMaterialCommandToRightBar("", FontImage.MATERIAL_ARROW_LEFT, new ActionListener() {
                   @Override
                   public void actionPerformed(ActionEvent evvt) {
                      new NewsfeedForm(res).showBack();
                   }
               });
     
      r=res;
          try {
              enim=EncodedImage.create("/giphy.gif");
             
              
            //img=URLImage.createToStorage(enim,"http://127.0.0.1:8000/uploads/Annonces/"+evt.getPathimg(), "http://127.0.0.1:8000/uploads/Annonces/"+evt.getPathimg(),URLImage.RESIZE_SCALE).scaled(500, 350);
           
            
              
           
              
              TextField firstname=new TextField(t.getFirstname());
              TextField lastname =new TextField(t.getLastname());
              TextField age =new TextField(Integer.toString(t.getAge()));
              TextField sexe =new TextField(t.getSexe());
              TextField email =new TextField(t.getEmail());
              TextField password =new TextField(t.getPassword());
              
            

            
             add(firstname);
              add(lastname);
              add(age);
              add(sexe);
              add(email);
              add(password);
             
             
              
              
              Button valide=new Button("Valide");
              valide.addActionListener(new ActionListener() {
                  @Override
                  public void actionPerformed(ActionEvent et) {
                     // t.setAdresse(adresse.getText());
                   
                    t.setFirstname(firstname.getText());
                      t.setLastname(lastname.getText());
                      t.setAge(Integer.valueOf(age.getText()));
                      t.setEmail(email.getText());
                      t.setSexe(sexe.getText());
                      t.setPassword(password.getText());
                     
                      Service.getInstance().updateTask(t);
                      new NewsfeedForm(r).showBack();
                  }
              });
              add(valide);
                      
                  
              
              
            
          } catch (IOException ex) {
              
          }
        
        
        
        
        
        
        
        
        
        Button back = new Button("Back");
        
        back.requestFocus();
        back.addActionListener(e -> new NewsfeedForm(res).show());
       
        
    }
}
