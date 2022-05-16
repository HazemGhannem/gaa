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

import com.codename1.ui.Button;
import com.codename1.ui.Component;
import com.codename1.ui.Container;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.layouts.Layout;
import com.codename1.ui.util.Resources;

/**
 * Utility methods common to forms e.g. for binding the side menu
 *
 * @author Shai Almog
 */
public class BaseForm extends Form {

    public BaseForm() {
    }

    public BaseForm(Layout contentPaneLayout) {
        super(contentPaneLayout);
    }

    public BaseForm(String title, Layout contentPaneLayout) {
        super(title, contentPaneLayout);
    }

    public Component createLineSeparator() {
        Label separator = new Label("", "WhiteSeparator");
        separator.setShowEvenIfBlank(true);
        return separator;
    }

    public Component createLineSeparator(int color) {
        Label separator = new Label("", "WhiteSeparator");
        separator.getUnselectedStyle().setBgColor(color);
        separator.getUnselectedStyle().setBgTransparency(255);
        separator.setShowEvenIfBlank(true);
        return separator;
    }

    public void installSidemenu(Resources res) {
        Image selection = res.getImage("logo.png");

        Image inboxImage = null;
        if (isCurrentInbox()) {
            inboxImage = selection;
        }

        Image trendingImage = null;
        if (isCurrentTrending()) {
            trendingImage = selection;
        }

        Image calendarImage = null;
        if (isCurrentCalendar()) {
            calendarImage = selection;
        }

        Image statsImage = null;
        if (isCurrentStats()) {
            statsImage = selection;
        }

        Button inboxButton = new Button("Inbox", inboxImage);
        inboxButton.setUIID("SideCommand");
        inboxButton.getAllStyles().setPaddingBottom(0);
        Container inbox = FlowLayout.encloseMiddle(inboxButton,
                new Label("18", "SideCommandNumber"));
        inbox.setLeadComponent(inboxButton);
        inbox.setUIID("SideCommand");
        //inboxButton.addActionListener(e -> new InboxForm().show());
        getToolbar().addComponentToSideMenu(inbox);
        //  getToolbar().addCommandToSideMenu("Annonces Ventes", trendingImage, e -> new TrendingForm(res).show());
        //  getToolbar().addCommandToSideMenu("Annonce Location", calendarImage, e -> new AnnonceLoc(res).show());
        // getToolbar().addCommandToSideMenu("Annonce Echange", calendarImage, e -> new AnnonceEch(res).show());
        // getToolbar().addCommandToSideMenu("Nos Points de location", calendarImage, e -> new GoogleMapsTestApp().start());
        //   getToolbar().addCommandToSideMenu("Mes Annonces", calendarImage, e -> new AnnoncesM(res).show());
        //    getToolbar().addCommandToSideMenu("Mes Réservations", calendarImage, e -> new MesResUI(res).show());
        getToolbar().addCommandToSideMenu("Users ", calendarImage, e -> new NewsfeedForm(res).show());
        getToolbar().addCommandToSideMenu("Statistique ", calendarImage, e -> new Statistique(res).show());
        getToolbar().addCommandToSideMenu("List ", calendarImage, e -> new HomeForm().show());

        //getToolbar().addCommandToSideMenu("Settings", null, e -> {});
        // spacer
    }

    protected boolean isCurrentInbox() {
        return false;
    }

    protected boolean isCurrentTrending() {
        return false;
    }

    protected boolean isCurrentCalendar() {
        return false;
    }

    protected boolean isCurrentStats() {
        return false;
    }
}
