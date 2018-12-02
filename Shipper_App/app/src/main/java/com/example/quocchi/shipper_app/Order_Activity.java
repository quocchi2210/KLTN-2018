package com.example.quocchi.shipper_app;

import android.content.Context;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

public class Order_Activity extends AppCompatActivity {

    private ArrayList<String> data = new ArrayList<String>();
    //public int position_index = -1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order);

        ListView lv = findViewById(R.id.list_view);

        data.add("fuck you");
        data.add("hello you");

        lv.setAdapter(new MyListAdapter(this, R.layout.list_item, data));
    }

    private class MyListAdapter extends ArrayAdapter<String> {
        private int layout;
        private MyListAdapter(Context context, int resource, List<String> objects){
            super(context, resource, objects);
            layout = resource;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent){
            try {


                ViewHolder mainViewholder = null;
                //final ViewHolder viewHolder = null;
                final int position_index = position;

                if (convertView == null) {
                    LayoutInflater inflater = LayoutInflater.from(getContext());
                    convertView = inflater.inflate(layout, parent, false);

                    final ViewHolder viewHolder = new ViewHolder();
                    viewHolder.thumbnail = (ImageView) convertView.findViewById(R.id.list_item_thumbnail);
                    viewHolder.title = (TextView) convertView.findViewById(R.id.list_item_text);
                    viewHolder.button = (Button) convertView.findViewById(R.id.list_item_btn);
                    viewHolder.button.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            //viewHolder.button.setText("fuck you");

                            //Toast.makeText(getContext(), "Button was clicked for list item " + position_index, Toast.LENGTH_SHORT).show();
                        }
                    });

                    convertView.setTag(viewHolder);
                } else {
                    mainViewholder = (ViewHolder) convertView.getTag();
                    mainViewholder.title.setText(getItem(position));
                }
                return convertView;
            }catch(Exception e) {
                e.printStackTrace();
                Log.e("Memory exceptions","exceptions"+e);
                return null;
            }


        }
    }

    public class ViewHolder{
        ImageView thumbnail;
        TextView title;
        Button button;
    }
}
