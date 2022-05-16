/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.pheonixui;

import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.uikit.entities.Category;
import com.codename1.uikit.services.ServiceCategory;

/**
 *
 * @author hp
 */
public class CategoryDelete extends Form {
     public CategoryDelete(Category p, Form previous) {
      //  setTitle("delete Personne");
        

        Button btnSubmit = new Button("Delete");
        Button btnret = new Button("return");
        
            btnret.addActionListener(e -> new HomeForm().show());
        
        
        btnSubmit.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                    Dialog.show("Alert", "Are you sure !!", new Command("OK"));
             
                    System.out.println(p.getId());
                    System.out.println("deleted Product");
                    
                    if (ServiceCategory.getInstance().Delete(p)) {
                        Dialog.show("Success", "Connection Accepted", new Command("OK"));
                    } else {
                        Dialog.show("ERROR", "Connection Failed", new Command("OK"));
                    }
                        
                }

         
      
        });
        

        addAll(btnSubmit,btnret);
      //  this.getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
    }

    
}
