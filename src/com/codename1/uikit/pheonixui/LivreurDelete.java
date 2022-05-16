/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.pheonixui;

import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.uikit.entities.Usedproduct;
import com.codename1.uikit.services.ServiceUsedproduct;

/**
 *
 * @author hp
 */
public class LivreurDelete extends Form {
     public LivreurDelete(Usedproduct p, Form previous) {
      //  setTitle("delete Personne");
        

        Button btnSubmit = new Button("Delete");
        Button btnret = new Button("return");
        
            btnret.addActionListener(e -> new HomeForm().show());
        
        
        btnSubmit.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                    Dialog.show("Alert", "Are you sure !!", new Command("OK"));
             
                 
                    System.out.println("deleted Product");
                    
                    if (ServiceUsedproduct.getInstance().Delete(p)) {
                        Dialog.show("Success", "Connection Accepted", new Command("OK"));
                    } else {
                        Dialog.show("ERROR", "Connection Failed", new Command("OK"));
                    }
                        
                }

         
      
        });
        

        addAll(btnSubmit,btnret);
     getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
    }




    
    
}
