package server;

/**
 * Created by siyuchen on 3/1/18.
 */

import java.util.concurrent.atomic.AtomicLong;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
@RestController
public class GreetingController {

    private static final String template = "Hello, %s!";
    private final AtomicLong counter = new AtomicLong();

    @RequestMapping("/shado-hello")
    public Greeting greeting(@RequestParam(value="name", defaultValue="This is Shado") String name) {
        return new Greeting(counter.incrementAndGet(),
                String.format(template, name));
    }

    @RequestMapping("/shado-test")
    public Index index(@RequestParam(value="name",defaultValue="Shado test response")String name){
        return new Index(counter.incrementAndGet(),
                String.format(template, name));
    }
}