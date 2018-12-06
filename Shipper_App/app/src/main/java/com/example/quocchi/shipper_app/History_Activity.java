package com.example.quocchi.shipper_app;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.BaseExpandableListAdapter;
import android.widget.Button;
import android.widget.ExpandableListView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.List;
import java.util.Map;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class History_Activity extends AppCompatActivity {

//    ListView lvHistory;
    //ArrayList<History> arrayHistory;

    private ArrayList<History> data = new ArrayList<History>();

    ExpandableListView expandableListView;
    List<NameStore> listContact;
    List<String> listdataHeader;
    HashMap<String,ArrayList<History>> listdataChild;

    CustomExpandableListView customExpandableListView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_history);

//        expandableListView = (ExpandableListView) findViewById(R.id.expandableListView);
//        listdataHeader = new ArrayList<String>();
//        listContact = new ArrayList<NameStore>();
//        listdataChild = new HashMap<String,ArrayList<History>>();
//
//        listdataHeader.add("A store");
//        listdataHeader.add("B store");
//        listdataHeader.add("C store");
//
//        listContact.add(new NameStore(1,"A store"));
//        listContact.add(new NameStore(2,"B store"));
//        listContact.add(new NameStore(3,"C store"));
//
//        ArrayList<History> store_a = new ArrayList<History>();
//        store_a.add(new History("math",1));
//        store_a.add(new History("math1",1));
//        store_a.add(new History("math2",1));
//
//        ArrayList<History> store_b = new ArrayList<History>();
//        store_b.add(new History("english",2));
//        store_b.add(new History("english1",2));
//        store_b.add(new History("english2",2));
//
//        ArrayList<History> store_c = new ArrayList<History>();
//        store_c.add(new History("gaphic",3));
//        store_c.add(new History("gaphic1",3));
//        store_c.add(new History("gaphic2",3));
//
//        listdataChild.put(listdataHeader.get(0),store_a);
//        listdataChild.put(listdataHeader.get(1),store_b);
//        listdataChild.put(listdataHeader.get(2),store_c);
//
//        customExpandableListView = new CustomExpandableListView(History_Activity.this,listdataHeader,listdataChild);
//        expandableListView.setAdapter(customExpandableListView);

        ArrayList<NameStore> values=new ArrayList<NameStore>();
        values.add(new NameStore(1,"A store"));
        values.add(new NameStore(1,"A store"));
        values.add(new NameStore(2,"A store"));
        HashSet<NameStore> hashSet = new HashSet<NameStore>();
        hashSet.addAll(values);
        values.clear();
        values.addAll(hashSet);

        Log.w("myApp", values.toString());

//        OkHttpClient client = new OkHttpClient();
//
//        RequestBody requestBody = new MultipartBody.Builder()
//                .setType(MultipartBody.FORM)
//                .addFormDataPart("your_name_input", "your_value")
//                .build();
//
//        Request request = new Request.Builder()
//                //.url("http://192.168.1.16:8000/api/shipper/showOrder")
//                .url(" http://192.168.0.132:8000/api/shipper/showOrder")
//                .post(requestBody)
//                //.addHeader("name_your_token", "your_token")
//                .build();
//
//        client.newCall(request).enqueue(new Callback() {
//            @Override
//            public void onFailure(Call call, IOException e) {
//                e.printStackTrace();
//            }
//
//            @Override
//            public void onResponse(Call call, Response response) throws IOException {
//                final String yourResponse = response.body().string();
//
//                if(response.isSuccessful()){
//
//                    History_Activity.this.runOnUiThread(new Runnable() {
//                        @Override
//                        public void run() {
//                            JSONObject Jobject = null;
//                            try {
//                                expandableListView = (ExpandableListView) findViewById(R.id.expandableListView);
//                                listdataHeader = new ArrayList<>();
//                                listdataChild = new HashMap<String,ArrayList<History>>();
//
//                                Jobject = new JSONObject(yourResponse);
//
//                                JSONArray Jarray = Jobject.getJSONArray("data");
//
//
//                                for (int i = 0; i < Jarray.length(); i++) {
//                                    JSONObject object = Jarray.getJSONObject(i);
//
//                                    listContact.add(new NameStore(Integer.parseInt(object.getString("idStore")),object.getString("nameStore")))
//                                    //listdataHeader.add();
////                                    Log.w("myApp", object.toString());
////                                    String billOfLading = object.getString("billOfLading");
////                                    String address = object.getString("addressReceiver");
////                                    data.add(new Order_Activity.Order(billOfLading,address));
//                                }
//
//                                customExpandableListView = new CustomExpandableListView(History_Activity.this,listdataHeader,listdataChild);
//                                expandableListView.setAdapter(customExpandableListView);
//
//
//                            } catch (JSONException e) {
//                                e.printStackTrace();
//                            }
//
//                        }
//                    });
//                }else{
//
//                }
//
//
//            }
//        });
//        lvHistory = (ListView) findViewById(R.id.list_history);
//        arrayHistory = new ArrayList<History>();
//
//
//        arrayHistory.add(new History("math",1));
//        arrayHistory.add(new History("history",1));
//        arrayHistory.add(new History("van hoc",1));
//
//        ArrayAdapter adapter = new ArrayAdapter(History_Activity.this, android.R.layout.simple_list_item_1, arrayHistory);
//
//        lvHistory.setAdapter(adapter);
//
//        lvHistory.setOnItemClickListener(new AdapterView.OnItemClickListener() {
//            @Override
//            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
//                Toast.makeText(History_Activity.this,arrayHistory.get(position).getA(),Toast.LENGTH_SHORT).show();
//
//            }
//        });
    }

    public class CustomExpandableListView extends BaseExpandableListAdapter {

        Context context;
        List<String> listHeader;
        HashMap<String,ArrayList<History>> listChild;

        public CustomExpandableListView(Context context, List<String> listHeader, HashMap<String, ArrayList<History>> listChild) {
            this.context = context;
            this.listHeader = listHeader;
            this.listChild = listChild;
        }

        @Override
        public int getGroupCount() {
            return listHeader.size();
        }

        @Override
        public int getChildrenCount(int groupPosition) {
            return listChild.get(listHeader.get(groupPosition)).size();
        }

        @Override
        public Object getGroup(int groupPosition) {
            return listHeader.get(groupPosition);
        }

        @Override
        public Object getChild(int groupPosition, int childPosition) {
            return listChild.get(listHeader.get(groupPosition)).get(childPosition);
        }

        @Override
        public long getGroupId(int groupPosition) {
            return groupPosition;
        }

        @Override
        public long getChildId(int groupPosition, int childPosition) {
            return childPosition;
        }

        @Override
        public boolean hasStableIds() {
            return false;
        }

        @Override
        public View getGroupView(int groupPosition, boolean isExpanded, View convertView, ViewGroup parent) {
            String headerTitle = (String) getGroup(groupPosition);

            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(R.layout.group_history_view,null);
            TextView txtheader = (TextView) convertView.findViewById(R.id.txt_history_header);
            txtheader.setText(headerTitle);

            return convertView;
        }

        @Override
        public View getChildView(int groupPosition, int childPosition, boolean isLastChild, View convertView, ViewGroup parent) {
            History test = (History) getChild(groupPosition,childPosition);

            //History a = listChild.get(listHeader.get(groupPosition));
            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(R.layout.group_history_child_view,null);

            TextView txta = (TextView) convertView.findViewById(R.id.txt_a);
            TextView txtb = (TextView) convertView.findViewById(R.id.txt_b);

            txta.setText( test.getA().toString());
            txtb.setText( test.getA().toString());


            return convertView;
        }

        @Override
        public boolean isChildSelectable(int groupPosition, int childPosition) {
            return true;
        }
    }

    private class HistoryAdapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<History> arrayOrder;

        public HistoryAdapter(Context context, int layout, List<History> orderList){
            myContext = context;
            myLayout = layout;
            arrayOrder = orderList;
        }

        @Override
        public int getCount() {
            return arrayOrder.size();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return 0;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {

            LayoutInflater inflater = (LayoutInflater) myContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(myLayout, null);

            //TextView list_item_text = (TextView) convertView.findViewById(R.id.list_item_text);

            final int vitri = position;

//            list_item_text.setText(data.get(position).getA());
//            Button list_item_btn = (Button) convertView.findViewById(R.id.list_item_btn);
//
//            list_item_btn.setOnClickListener(new View.OnClickListener() {
//                @Override
//                public void onClick(View view) {
//                    Toast.makeText(Order_Activity.this,data.get(vitri).getA(),Toast.LENGTH_SHORT).show();
//                }
//            });

            return convertView;
        }
    }


    private class History{
        private String a;
        private int b;

        History(String a, int b){
            this.a = a;
            this.b = b;
        }


        public String getA() {
            return a;
        }

        public void setA(String a) {
            this.a = a;
        }
    }

    private class NameStore{
        private int id_store;
        private String name_store;
        public NameStore(int id_store, String name_store) {
            this.id_store = id_store;
            this.name_store = name_store;
        }

        public int getId_store() {
            return id_store;
        }

        public void setId_store(int id_store) {
            this.id_store = id_store;
        }

        public String getName_store() {
            return name_store;
        }

        public void setName_store(String name_store) {
            this.name_store = name_store;
        }

    }
}
