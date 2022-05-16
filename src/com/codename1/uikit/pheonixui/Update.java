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
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.uikit.entities.Usedproduct;
import com.codename1.uikit.services.ServiceUsedproduct;

/**
 *
 * @author hp
 */
public class Update extends Form {
        Form current;

   public Update(Usedproduct p , Form previous) {
        setTitle("edit Usedproduct");
        setLayout(BoxLayout.y());
        TextField tfid = new TextField(String.valueOf(p.getId()), "Usedproduct cin");
        TextField tfName = new TextField(p.getName(), "Usedproduct name");
        TextField tfimage = new TextField(p.getImage(), "Usedproduct prenom");
        TextField tfdescription = new TextField((p.getDescription()), "Usedproduct rating");
        TextField tfprix = new TextField(String.valueOf(p.getPrix()), "Usedproduct image");
        

        Button btnValider = new Button("edit Usedproduct");
        Button btnRet = new Button("Return");
        btnRet.addActionListener(e-> new HomeForm().show() );

        btnValider.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                if ((tfName.getText().length() == 0) && (tfimage.getText().length() == 0) && (tfdescription.getText().length() == 0) && (tfprix.getText().length() == 0) ) {
                    Dialog.show("Alert", "Please fill all the fields", new Command("OK"));
                } else {
                    try {
                        Usedproduct p = new Usedproduct(Integer.parseInt(tfid.getText()), 17, tfName.getText(),tfimage.getText(),tfdescription.getText(),Float.parseFloat(tfprix.getText()));
                       
                       
                        System.out.println("---------");
                        
                        if (ServiceUsedproduct.getInstance().modifierProduct(p)) {
                            Dialog.show("Success", "Connection accepted", new Command("OK"));
                        } else {
                            Dialog.show("ERROR", "Server error", new Command("OK"));
                        }
                    } catch (NumberFormatException e) {
                        Dialog.show("ERROR", "Status must be a number", new Command("OK"));
                    }

                }

            }

            
        });
        

        addAll(tfid, tfName, tfimage, tfdescription, tfprix, btnValider,btnRet);
        // getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> this.previous.showBack());

    }
    
}
