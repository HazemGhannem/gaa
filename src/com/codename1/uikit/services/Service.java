/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.Dialog;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionListener;
import com.codename1.uikit.entities.Task;
import com.codename1.uikit.utils.Statics;
import java.io.IOException;
import java.text.ParseException;
import java.text.SimpleDateFormat;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author bhk
 */
public class Service {

    public ArrayList<Task> tasks;
    boolean ok = false;

    public static Service instance = null;
    public boolean resultOK;
    public ConnectionRequest req;

    public Service() {
        req = new ConnectionRequest();
    }

    public static Service getInstance() {
        if (instance == null) {
            instance = new Service();
        }
        return instance;
    }

    public boolean addTask(Task t) {
        String url = Statics.BASE_URL + "jsonuser/add?email=" + t.getEmail() + "&password=" + t.getPassword() + "&firstname=" + t.getFirstname() + "&lastname=" + t.getLastname() + "&age=" + t.getAge() + "&sexe=" + t.getSexe();
        req.setUrl(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }

    public boolean updateTask(Task t) {
        String url = Statics.BASE_URL + "jsonuser/edit/" + t.getId() + "?email=" + t.getEmail() + "&password=" + t.getPassword() + "&firstname=" + t.getFirstname() + "&lastname=" + t.getLastname() + "&age=" + t.getAge() + "&sexe=" + t.getSexe();
        req.setUrl(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }

    public boolean Delete(Task t) {
        String url = Statics.BASE_URL + "jsonuser/delete/" + t.getId();
        req.setUrl(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }

    public ArrayList<Task> parseTasks(String jsonText) throws ParseException {
        try {
            tasks = new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String, Object> tasksListJson = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));

            List<Map<String, Object>> list = (List<Map<String, Object>>) tasksListJson.get("root");
            for (Map<String, Object> obj : list) {
                Task t = new Task();
                float id = Float.parseFloat(obj.get("id").toString());
                float age = Float.parseFloat(obj.get("age").toString());
                t.setId((int) id);

                t.setEmail(obj.get("email").toString());
                t.setAge((int) age);
                t.setFirstname(obj.get("firstname").toString());
                t.setLastname(obj.get("lastname").toString());
                t.setSexe(obj.get("sexe").toString());
                t.setPassword(obj.get("password").toString());

                tasks.add(t);
            }

        } catch (IOException ex) {

        }
        return tasks;
    }

    public ArrayList<Task> getAllTasks() {

        String url = Statics.BASE_URL + "jsonuser/all";
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                    tasks = parseTasks(new String(req.getResponseData()));
                } catch (ParseException ex) {

                }
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return tasks;
    }

    public ArrayList<Task> getAllTasksByNom(String text) {

        String url = Statics.BASE_URL + "jsonuser/all/" + text;
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                    tasks = parseTasks(new String(req.getResponseData()));
                } catch (ParseException ex) {

                }
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return tasks;
    }

    public boolean signin(TextField email, TextField password) {

        String url = Statics.BASE_URL + "jsonuser/login?email=" + email.getText().toString() + "&password=" + password.getText().toString();
        req = new ConnectionRequest(url, false); //false ya3ni url mazlt matba3thtich lel server
        req.setUrl(url);

        req.addResponseListener((e) -> {

            JSONParser j = new JSONParser();

            String json = new String(req.getResponseData()) + "";

            try {

                if (json.equals("password incorrect") || json.equals("email don't have account")) {
                    Dialog.show("Echec d'authentification", "Username ou mot de passe éronné", "OK", null);
                    ok = false;
                } else if (json != "") {
                    System.out.println("data ==" + json);
                    ok = true;
                    Map<String, Object> user = j.parseJSON(new CharArrayReader(json.toCharArray()));

                    //Session
                    //   float id = Float.parseFloat(user.get("id_user").toString());
                    //   float tel = Float.parseFloat(user.get("tel").toString());
                    //  float age = Float.parseFloat(user.get("age").toString());
                    //SessionManager.setId_user((int)id);//jibt id ta3 user ly3ml login w sajltha fi session ta3i
                    //SessionManager.setPassword(user.get("password").toString());
                    //SessionManager.setUsername(user.get("username").toString());
                    //SessionManager.setEmail(user.get("email").toString());
                    //SessionManager.setNom(user.get("nom").toString());
                    //SessionManager.setPrenom(user.get("prenom").toString());
                    //SessionManager.setTel((int)tel);
                    // SessionManager.setAge((int)age);
                }

            } catch (Exception ex) {
                ex.printStackTrace();
            }

        });

        //ba3d execution ta3 requete ely heya url nestanaw response ta3 server.
        NetworkManager.getInstance().addToQueueAndWait(req);
        return ok;
    }

}
